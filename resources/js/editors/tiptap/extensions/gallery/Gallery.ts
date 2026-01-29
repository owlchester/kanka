
import { Extension } from '@tiptap/core'

export interface GalleryOptions {
    galleryUrl: string
}

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        gallery: {
            openGallery: () => ReturnType
        }
    }
}

export const Gallery = Extension.create<GalleryOptions>({
    name: 'gallery',

    addOptions() {
        return {
            galleryUrl: '',
        }
    },

    addCommands() {
        return {
            openGallery: () => ({ editor }) => {
                // Dispatch custom event to open the gallery dialog
                const event = new CustomEvent('tiptap:open-gallery', {
                    detail: { editor, galleryUrl: this.options.galleryUrl }
                })
                window.dispatchEvent(event)
                return true
            },
        }
    },
})
