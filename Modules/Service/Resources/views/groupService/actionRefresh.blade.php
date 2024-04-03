<script>
    refreshDataGlobal();
    const runGlobalRefresh = () => {
        if (getGlobalRefresh === true) {
            runDataPengembalian();
            $('.areaPenerimaanServis').hide();
            $('.areaPengembalianServis').show();
        } else {
            const statusCancel = ['tidak bisa', 'cancel', 'komplain garansi', 'sudah diambil'];
            if (!statusCancel.includes(getGlobalRefresh)) {
                runDataPenerimaan();
                $('.areaPenerimaanServis').show();
                $('.areaPengembalianServis').hide();
            } else {
                runDataPengembalian();
                $('.areaPenerimaanServis').hide();
                $('.areaPengembalianServis').show();
            }
        }
    };
    runGlobalRefresh();
</script>
