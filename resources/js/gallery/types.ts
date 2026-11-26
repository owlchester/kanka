export type GalleryViewMode = 'grid-md' | 'grid-sm' | 'table'
export type GallerySort = 'recent' | 'oldest' | 'updated_asc' | 'name_asc' | 'name_desc' | 'size_desc' | 'size_asc' | 'used_desc' | 'used_asc'
export type GalleryScope = 'folder' | 'all'
export type GalleryUsage = 'all' | 'unused' | 'used'
export type GalleryFileType = 'all' | 'image' | 'svg' | 'font'
export type GalleryOrientation = 'all' | 'landscape' | 'portrait' | 'square'

export interface GalleryFileApi {
    show: string
    update: string
    delete: string
    focus: string
    replace: string
}

export interface GalleryFileItem {
    id: string
    folder_id: string | null
    is_folder: boolean
    is_font: boolean
    is_svg: boolean
    is_default: boolean
    name: string
    description: string | null
    author: string | null
    thumbnail: string | null
    original: string | null
    thumbnails: string[] | null
    visibility_id: number | string
    focus_x: number | null
    focus_y: number | null
    is_selected: boolean
    is_deleted: boolean
    open: string
    link: string
    admin_url: string
    ext: string | null
    size: string
    size_kb: number
    width: number | null
    height: number | null
    items_count: number | null
    usage_count: number | null
    creator_id: number | null
    creator: string
    created_at: string | null
    created_at_human: string | null
    updated_at: string | null
    updated_at_human: string | null
    can_edit: boolean
    api: GalleryFileApi
}

export interface GalleryFolderNode {
    id: string
    name: string
    folder_id: string | null
    items_count: number
}

export interface GalleryBreadcrumb {
    id: string
    name: string
    open: string
}

export interface GalleryPagination {
    current_page: number
    last_page: number
    per_page: number
    total: number
    from: number
    to: number
}

export interface GalleryUploader {
    id: number
    name: string
}

export interface GallerySetupData {
    acl: {
        manage: boolean
        upload: boolean
        premium: boolean
        elemental: boolean
        wyvern: boolean
        user_id: number
    }
    i18n: Record<string, string>
    folders: Record<string, string>
    folder_tree: GalleryFolderNode[]
    uploaders: GalleryUploader[]
    api: {
        items: string
        search: string
        delete: string
        deletePreview: string
        create: string
        update: string
        upload: string
        uploadUrl: string
    }
    visibilities: Record<string, string>
    bulkVisibilities: Record<string, string>
    url: string
    space: {
        total: number
        used: number
    }
    upgrade: string | null
}

export interface GalleryUsageItem {
    name: string
    url: string
    type?: string
    entity_name?: string
    post_name?: string
    image_name?: string
}

export interface GalleryUsages {
    entity_images: GalleryUsageItem[]
    entity_headers: GalleryUsageItem[]
    entry_mentions: GalleryUsageItem[]
    map_layers: GalleryUsageItem[]
    entity_assets: GalleryUsageItem[]
    inventories: GalleryUsageItem[]
    is_default: boolean
}

export interface DeletePreviewData {
    total_files: number
    total_folders: number
    total_size_kb: number
    total_size_readable: string
    has_entry_mentions: boolean
    has_impacts: boolean
    impacts: {
        entry_mentions: GalleryUsageItem[]
        entity_images: GalleryUsageItem[]
        entity_headers: GalleryUsageItem[]
        map_layers: GalleryUsageItem[]
        entity_assets: GalleryUsageItem[]
        inventories: GalleryUsageItem[]
        default_images: Array<{ image_id: string; image_name: string }>
    }
}

export interface UploadQueueItem {
    uid: string
    file: File
    name: string
    folderId: string | null
    progress: number
    status: 'queued' | 'uploading' | 'done' | 'error' | 'cancelled'
    error: string | null
    preview: string | null
    controller: AbortController | null
}
