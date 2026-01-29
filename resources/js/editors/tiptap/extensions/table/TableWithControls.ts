
import { Table } from '@tiptap/extension-table'
import { VueNodeViewRenderer } from '@tiptap/vue-3'
import TableWrapper from './TableWrapper.vue'

export const TableWithControls = Table.extend({
    addNodeView() {
        return VueNodeViewRenderer(TableWrapper)
    },
})
