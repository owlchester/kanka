
import { Extension } from '@tiptap/core'
import axios from 'axios'

declare global {
    interface Window {
        showToast: (message: string, type?: string) => void
    }
}

export interface GalleryOptions {
    galleryUrl: string
}

declare module '@tiptap/core' {
    interface Commands<ReturnType> {
        gallery: {
            openGallery: () => ReturnType
            uploadMedia: () => ReturnType
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
            uploadMedia: () => ({ editor }) => {
                const galleryUrl = this.options.galleryUrl
                const input = document.createElement('input')
                input.type = 'file'
                input.accept = 'image/png,image/jpg,image/jpeg,image/gif,image/webp'

                input.onchange = async () => {
                    const file = input.files?.[0]
                    if (!file) return

                    const formData = new FormData()
                    formData.append('file', file)

                    try {
                        const response = await axios.post(galleryUrl, formData)
                        if (response.status === 200 && response.data) {
                            editor
                                .chain()
                                .focus()
                                .setImage({
                                    src: response.data.src,
                                    'data-uuid': response.data.uuid,
                                })
                                .run()
                        }
                    } catch (error: any) {
                        if (error.response?.status === 204 || error.response?.data) {
                            const errors = error.response?.data?.errors || error.response?.data || 'Upload failed'
                            window.showToast(errors, 'error')
                        } else {
                            window.showToast('Upload failed', 'error')
                        }
                    }
                }

                input.click()
                return true
            },
        }
    },
})
