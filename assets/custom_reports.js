/*lap. daftar perusahaan (mod-penyedia-kerja) */
function checkdate(date1, date2){
    if(date2 < date1){
        return 0;
    }else{
        return 1;
    }
}

$("#btn_excel_dataBM").click(function(){
    var date1 = $("#tglawal").val();
    var date2 = $("#tglakhir").val();
    var cekdate = checkdate(new Date(date1), new Date(date2));
    
    if(cekdate > 0 && (date1 !== "" || date2 !== "")){
        $("#alert_date").hide();
        $("#LapDataBM").attr('action', 'LaporanBarangMasuk/ExpExcelDataBM');
        $("#LapDataBM").submit();
    }else{
        $("#tglawal").val(""); $("#tglawal").val("");
        $("#alert_date").show();
    }
});

$("#cekdetailBK").click(function(){
    var cekdet = document.getElementById("cekdetailBK");
    if(cekdet.checked == true){
        $("#namabarangBK").show();
    }else{
        $("#namabarangBK").hide();
    }
});

$("#btn_excel_dataBK").click(function(){
    var date1 = $("#tglawal").val();
    var date2 = $("#tglakhir").val();
    var cekdate = checkdate(new Date(date1), new Date(date2));
    
    if(cekdate > 0 && (date1 !== "" || date2 !== "")){
        $("#alert_date").hide();
        $("#LapDataBK").attr('action', 'LaporanBarangKeluar/ExpExcelDataBK');
        $("#LapDataBK").submit();
    }else{
        $("#tglawal").val(""); $("#tglawal").val("");
        $("#alert_date").show();
    }
});

$("#btn_excel_kartustock").click(function(){
    var date1 = $("#tglawal").val();
    var date2 = $("#tglakhir").val();
    var cekdate = checkdate(new Date(date1), new Date(date2));
    
    var brg = $("#nmbarang").val();
    if(brg === ""){
        alert("Nama barang wajib dipilih!!");
        $("#alert_date").hide();
    }
    
    if(cekdate > 0 && (date1 !== "" || date2 !== "") && (brg !== "")){
        $("#alert_date").hide();
        $("#LapKartuStock").attr('action', 'KartuStock/ExpExcelKartu');
        $("#LapKartuStock").submit();
    }else{
        $("#tglawal").val(""); $("#tglawal").val("");
        $("#alert_date").show();
    }
});