<div class="card-header bg-primary text-white p-3">
    <strong>Detail Customer</strong>
</div>
<div class="card-body">
    <div class="mt-4 row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-select-vertical label="Cari Customer" name="customer_id" :data="$array_customer"
                        value="" />
                </div>
            </div>
            <div class="mt-2 mb-2">
                <div id="load_customer_id"></div>
            </div>
        </div>
    </div>
</div>