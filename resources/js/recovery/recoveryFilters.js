export function elementKey(model) {
    return `${model.type}-${model.id}`;
}

export function buildDeletedByOptions(models) {
    const counts = new Map();

    for (const model of models) {
        const value = String(model.deleted_by ?? 'unknown');
        const existing = counts.get(value);
        if (existing) {
            existing.count += 1;
        } else {
            counts.set(value, {
                value,
                label: model.deleted_name || 'Unknown',
                count: 1,
            });
        }
    }

    return Array.from(counts.values()).sort((a, b) => a.label.localeCompare(b.label));
}

export function buildTypeOptions(models) {
    const counts = new Map();

    for (const model of models) {
        const value = `${model.type}:${model.type_id}`;
        const existing = counts.get(value);
        if (existing) {
            existing.count += 1;
        } else {
            counts.set(value, {
                value,
                label: model.type_name || model.type,
                count: 1,
            });
        }
    }

    return Array.from(counts.values()).sort((a, b) => a.label.localeCompare(b.label));
}

export function filterAndSortModels(
    models,
    {
        search = '',
        deletedBy = '',
        type = '',
        timeframe = '',
        sort = 'newest',
        nowSeconds = Math.floor(Date.now() / 1000),
    } = {},
) {
    const query = search.trim().toLowerCase();

    const filtered = models.filter((model) => {
        if (query) {
            const matchesSearch = [
                model.name,
                model.parent_name,
                model.type_name,
                model.deleted_name,
            ].some((field) => field && String(field).toLowerCase().includes(query));

            if (!matchesSearch) {
                return false;
            }
        }

        if (deletedBy && String(model.deleted_by ?? 'unknown') !== deletedBy) {
            return false;
        }

        if (type && `${model.type}:${model.type_id}` !== type) {
            return false;
        }

        if (timeframe) {
            const ageSeconds = nowSeconds - (model.deleted_at_timestamp ?? 0);

            if (timeframe === '24h' && ageSeconds > 86400) {
                return false;
            }
            if (timeframe === '7d' && ageSeconds > 7 * 86400) {
                return false;
            }
            if (timeframe === '30d' && ageSeconds > 30 * 86400) {
                return false;
            }
            if (timeframe === 'expiring' && !(typeof model.days_left === 'number' && model.days_left <= 7)) {
                return false;
            }
        }

        return true;
    });

    return filtered.sort((a, b) => {
        if (sort === 'oldest') {
            return (
                (a.deleted_at_timestamp ?? 0) - (b.deleted_at_timestamp ?? 0) ||
                (b.position ?? 0) - (a.position ?? 0)
            );
        }

        if (sort === 'name') {
            return String(a.name || '').localeCompare(String(b.name || ''));
        }

        if (sort === 'type') {
            return (
                String(a.type_name || '').localeCompare(String(b.type_name || '')) ||
                (b.deleted_at_timestamp ?? 0) - (a.deleted_at_timestamp ?? 0)
            );
        }

        return (
            (b.deleted_at_timestamp ?? 0) - (a.deleted_at_timestamp ?? 0) ||
            (a.position ?? 0) - (b.position ?? 0)
        );
    });
}
