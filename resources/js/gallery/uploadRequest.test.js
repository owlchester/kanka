import test from 'node:test'
import assert from 'node:assert/strict'
import { createUploadRequest } from './uploadRequest.js'

test('creates an abortable upload request without overriding multipart headers', () => {
    const onUploadProgress = () => {}
    const request = createUploadRequest(onUploadProgress)

    assert.equal(request.config.signal, request.controller.signal)
    assert.equal(request.config.onUploadProgress, onUploadProgress)
    assert.equal('headers' in request.config, false)
    assert.equal('cancelToken' in request.config, false)

    request.controller.abort()

    assert.equal(request.config.signal.aborted, true)
})
