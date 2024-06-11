<x-form :action="['bulk.process', $campaign]" direct>
    <div class="modal fade" id="bulk-ajax" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-base-100">
            </div>
        </div>
    </div>
    <input type="hidden" name="mode" value="{{ $mode }}" />
    <input type="hidden" name="models" value="" id="datagrid-bulk-ajax-models" />
</x-form>
