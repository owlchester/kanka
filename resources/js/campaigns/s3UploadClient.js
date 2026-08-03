export const APP_HEADERS_TO_STRIP = ['X-Requested-With', 'X-XSRF-TOKEN', 'X-CSRF-TOKEN', 'Authorization']

export const createS3UploadClient = (axios) => {
    const client = axios.create()

    for (const header of APP_HEADERS_TO_STRIP) {
        delete client.defaults.headers.common[header]
    }

    return client
}
