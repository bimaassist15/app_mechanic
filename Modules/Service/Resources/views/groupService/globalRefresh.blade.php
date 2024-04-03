<script class="url_root" data-url="{{ url('/') }}"></script>
<script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
<script>
    var urlRoot = $('.url_root').data('url');
    var jsonPenerimaanServisId = $('.penerimaanServisId').data('value');
    var getGlobalRefresh = false;

    const refreshDataGlobal = () => {
        $.ajax({
            url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}`,
            dataType: "json",
            type: "get",
            data: {
                refresh: true,
            },
            async: false,
            success: function(data) {
                const rowData = data.row;
                const statusAllowed = ["bisa diambil"];
                if (statusAllowed.includes(rowData.status_pservis)) {
                    getGlobalRefresh = true;
                } else {
                    getGlobalRefresh = rowData.status_pservis;
                }
            },
        });

        return getGlobalRefresh;
    };
</script>
