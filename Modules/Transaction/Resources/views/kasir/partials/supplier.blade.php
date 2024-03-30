<div class="card-header bg-primary text-white p-3">
    <strong>Detail Supplier</strong>
</div>
<div class="card-body">
    <div class="mt-4 row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-select-vertical label="Cari Supplier" name="supplier_id" :data="$array_supplier"
                        value="" />
                </div>
            </div>
            <div class="mt-2 mb-2">
                <div class="load_supplier_id"></div>
            </div>
        </div>
    </div>
</div>