import { test } from 'node:test'
import assert from 'node:assert/strict'
import { htmlToPlainText, htmlToPreviewText } from './entryText.js'

test('htmlToPlainText converts <p> boundaries into blank lines', () => {
    assert.equal(htmlToPlainText('<p>First paragraph.</p><p>Second paragraph.</p>'), 'First paragraph.\n\nSecond paragraph.')
})

test('htmlToPlainText converts <br> into a single newline', () => {
    assert.equal(htmlToPlainText('<p>Line one.<br>Line two.</p>'), 'Line one.\nLine two.')
})

test('htmlToPlainText decodes escaped html entities back to literal characters', () => {
    assert.equal(
        htmlToPlainText('<p>5 &lt; 10 &amp; 10 &gt; 5 &quot;really&quot; &#039;yes&#039;</p>'),
        '5 < 10 & 10 > 5 "really" \'yes\'',
    )
})

test('htmlToPlainText strips unexpected tags without losing their text content', () => {
    assert.equal(htmlToPlainText('<p><strong>Bold</strong> text</p>'), 'Bold text')
})

test('htmlToPlainText does not treat tags merely starting with "p" as paragraph tags', () => {
    assert.equal(htmlToPlainText('<pre>code</pre>'), 'code')
})

test('htmlToPlainText returns an empty string for null, undefined, or empty input', () => {
    assert.equal(htmlToPlainText(null), '')
    assert.equal(htmlToPlainText(undefined), '')
    assert.equal(htmlToPlainText(''), '')
})

test('htmlToPlainText is a no-op on already-plain text', () => {
    assert.equal(htmlToPlainText('First paragraph.\n\nSecond paragraph.'), 'First paragraph.\n\nSecond paragraph.')
})

test('htmlToPreviewText collapses paragraph breaks and whitespace into single spaces', () => {
    assert.equal(htmlToPreviewText('<p>First paragraph.</p><p>Second paragraph.</p>'), 'First paragraph. Second paragraph.')
})

test('htmlToPreviewText returns an empty string for empty input', () => {
    assert.equal(htmlToPreviewText(''), '')
})
