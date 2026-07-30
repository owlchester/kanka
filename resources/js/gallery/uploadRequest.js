export const createUploadRequest = (onUploadProgress) => {
    const controller = new AbortController()

    return {
        controller,
        config: {
            signal: controller.signal,
            onUploadProgress,
        },
    }
}
