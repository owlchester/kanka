import test from 'node:test'
import assert from 'node:assert/strict'
import { createS3UploadClient } from './s3UploadClient.js'

const fakeAxios = (commonHeaders) => ({
    create: () => ({
        defaults: {
            headers: {
                common: { ...commonHeaders },
            },
        },
    }),
})

test('strips app-specific auth headers before they reach the presigned S3 URL', () => {
    const axios = fakeAxios({
        Accept: 'application/json, text/plain, */*',
        'X-Requested-With': 'XMLHttpRequest',
        'X-XSRF-TOKEN': 'xsrf-value',
        'X-CSRF-TOKEN': 'csrf-value',
        Authorization: 'Bearer token',
    })

    const client = createS3UploadClient(axios)

    assert.equal('X-Requested-With' in client.defaults.headers.common, false)
    assert.equal('X-XSRF-TOKEN' in client.defaults.headers.common, false)
    assert.equal('X-CSRF-TOKEN' in client.defaults.headers.common, false)
    assert.equal('Authorization' in client.defaults.headers.common, false)
    assert.equal(client.defaults.headers.common.Accept, 'application/json, text/plain, */*')
})
