import { createApp } from 'vue';
import MobileReader from './reader/MobileReader.vue';

export const mountReaders = (nodes) => {
    nodes.forEach((node) => {
        if (node.dataset.readerMounted) {
            return;
        }
        node.dataset.readerMounted = 'true';
        createApp(MobileReader, {
            root: node.closest('.entity-grid'),
            labels: JSON.parse(node.dataset.labels),
            entityId: node.dataset.entityId,
        }).mount(node);
    });
};
