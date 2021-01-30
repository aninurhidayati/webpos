//add dynamic row tab pendidikan registrasi pencaker
$(document).ready(function(){
    var count = 0; var jml=0;
    $('#btnTambahBarang').click(function(){
//        alert("masuk: "+$("#cariDataBarang").val()+$("#tgl_masuk").val());        
      if ($("#cariDataBarang").val() == "") {
        alert("Pilih Barang Tidak Boleh Kosong", "Pilih Barang!");
        $("#cariDataBarang").show().focus().click();
      } else if ($("#hpp").val() == "") {
        alert("Form HPP Tidak Boleh Kosong", "Masukkan Nilai HPP!");
        $("#hpp").focus();
      } else if ($("#jml_stok").val() == "") {
        alert("Jumlah Stok Tidak Boleh Kosong", "Masukkan Jumlah Stok!");
        $("#jml_stok").focus();
      } else if ($("#satuan").val() == "") {
        alert("Satuan Barang Tidak Boleh Kosong", "Masukkan nilai satuan barang!");
        $("#satuan").focus();
      } else {
        count = count + 1;
        var cariDataBarang = $('#cariDataBarang').val(); 
        var tgl_masuk = $('#tgl_masuk').val(); var hpp = $('#hpp').val(); var ppn = $('#ppn').val();
        var jml_stok = $('#jml_stok').val(); var satuan =  $('#satuan').val(); var hpp_ppn = ((ppn/100)*hpp)+parseInt(hpp);
        var total = jml_stok*hpp;
        var html_code = "<tr id='row"+count+"' style='padding: 0px!important;'>";
         html_code += "<td class='centerpad7'><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'><i class='fa fa-times'></i></button></td>";
         html_code += "<td class='centerpad7'><input type='hidden' name='v_kodebarang[]' value='"+cariDataBarang.split('-',2)[0]+"' />"+cariDataBarang.split('-',2)[0]+"</td>";
         html_code += "<td class='centerpad7'><input type='hidden' name='v_databarang[]' value='"+cariDataBarang.split('-',2)[1]+"' />"+cariDataBarang.split('-',2)[1]+"</td>";
         html_code += "<td class='centerpad7'><input type='hidden' name='v_jmlstok[]' value='"+jml_stok+"'>\n\
                        <input type='hidden' name='v_satuan[]' value='"+satuan+"'>"+jml_stok+" "+satuan+"</td>";
         html_code += "<td class='text_right' ><input class='text-right' type='hidden' name='v_hpp[]' value='"+hpp+"'>"+hpp+"</td>";
         html_code += "<td class='text_right' ><input class='text-right' type='hidden' name='v_hpp_ppn[]' value='"+hpp_ppn+"'>"+hpp_ppn+"</td>";
         html_code += "<td class='text-right'  style='margin-left:4px!important;'>\n\
                        <input type='hidden' class='v_total text-right inputku' readonly='true' name='v_total[]' value='"+total+"'>"+total+"</td>";         
         html_code += "</tr>";  
         $('#detailtabelbarang').append(html_code);
         sumOfBM();
         jml = jml+1;
         $('#cariDataBarang').val("");
         $('#hpp').val(""); 
         $('#jml_stok').val("");          
      }
    });
    
    function sumOfBM(){
        var total = 0;
        $('.v_total').each(function (index, element) {
            total = total + parseFloat($(element).val());
        });
        $("#subtotal").val(total);
        var ppn = $("#ppn").val(); 
        var ttl_ppn = ppn/100*total;
        $("#txt_ppn").val(ttl_ppn);
        $("#totalbayar").val(total + ttl_ppn);
    }
    
    $('#ppn').change(function(){
        var total = $("#subtotal").val();
        var ppn = $("#ppn").val(); 
        var ttl_ppn = ppn/100*total;
        $("#txt_ppn").val(ttl_ppn);
        $("#totalbayar").val(total + ttl_ppn);
    });  

    $(document).on('click', '.remove', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
        sumOfBM();
    });
    
    //cek nofaktur barang masuk
    $('#nofaktur_bm').change(function(){
        var nofak =  $('#nofaktur_bm').val();
        $.ajaxSetup({
            type:"POST",
            url: "cekFakturBM",
            cache: false
        });
        $.ajax({
            data:{ kodefak:nofak },
            success: function(respond){       
                console.log(respond);
                if(respond > 0){
                    alert("Nomor Faktur Sudah Pernah di Input!!");
                    $('#nofaktur_bm').val("");
                    $('#nofaktur_bm').focus();
                }             
            },
            error: function(data){
                alert('Gagal Generate Code! AJAX error!');
            }
        });
    });
    
    //cek nofaktur barang keluar
    $('#nofaktur_bk').change(function(){
        var nofak =  $('#nofaktur_bk').val();
        $.ajaxSetup({
            type:"POST",
            url: "cekFakturBK",
            cache: false
        });
        $.ajax({
            data:{ kodefak:nofak },
            success: function(respond){       
                console.log(nofak+ ": "+respond);
                if(respond > 0){
                    alert("Nomor Faktur Sudah Pernah di Input!!");
                    $('#nofaktur_bk').val("");
                    $('#nofaktur_bk').focus();
                }             
            },
            error: function(data){
                alert('Gagal Generate Code! AJAX error!');
            }
        });
    });
    
    //ketika barang keluar/transaksi
    $('#brg_keluar').change(function(){
        var barang = $('#brg_keluar').val();
        var iddet_brg = barang.split('/',2)[0]
        var kode_brg = barang.split('/',2)[1];
        var nama_brg = barang.split('/',4)[2];
        var harga_brg = barang.split('/',4)[3];
        var sisastok = barang.split('/',6)[4];
        $("#bm_stok").val(sisastok);
        $("#bm_hpp").val(harga_brg);
        //console.log(iddet_brg+" - " +kode_brg+" - "+nama_brg+" - "+harga_brg);
        //$('#harga').val(harga_brg);
        $('#jml_beli').show().focus();
    });
    //cek stok
    $('#jml_beli').change(function(){
        var jmlbeli = $('#jml_beli').val();
        var sisastok = $("#bm_stok").val();
        if(parseInt(jmlbeli) > parseInt(sisastok)){
            $('#warning_add').append("");
            $('#warning_add').show();
            $('#warning_add').append("Jumlah Beli Melebihi Stok , <b>sisa stok "+sisastok+"</b>");
            $('#jml_beli').val("");
            $("#jml_beli").show().focus().click();
        }else{
            $('#warning_add').append("");
            $('#warning_add').hide();
            $("#harga").show().focus().click();
        }
    });
    
    //cek harga
    $('#harga').change(function(){
        var hpp = $('#bm_hpp').val();
        var harga = $("#harga").val();
        if(harga <= hpp){
            $('#warning_add').append("");
            $('#warning_add').show();
            $('#warning_add').append("Harga Jual Harus Lebih Besar dari HPP , <b>HPP: "+harga+"</b>");
            $('#harga').val("");
            $("#harga").show().focus().click();
        }else{
            $('#warning_add').append("");
            $('#warning_add').hide();
        }
    });
    
    $('#btn_tmb_brg').click(function(){
        if ($("#brg_keluar").val() == "") {
            alert("Nama Barang Belum Dipilih!!", "Pilih Barang!");
            $("#brg_keluar").focus().click();
        } else if ($("#jml_beli").val() == "") {
            alert("Jumlah Beli Belum Diisi!!", "Masukkan Jumlah!");
            $("#jml_beli").show().focus().click();
        } else{
            var barang = $('#brg_keluar').val();
            var iddet_brg = barang.split('/',2)[0];
            var kode_brg = barang.split('/',2)[1];
            var nama_brg = barang.split('/',4)[2];
            var hpp = barang.split('/',4)[3];
            
            var harga_brg =  $("#harga").val();
            var jml_brg = $("#jml_beli").val();
            var totalhrg = jml_brg*harga_brg;  
            count = count + 1;
            var html_code = "<tr id='row"+count+"'>";
                html_code += "<td class='centerpad7'><button type='button' name='remove_bk' data-row='row"+count+"' class='btn btn-danger btn-xs remove_bk'><i class='fa fa-times'></i></button></td>";
                html_code += "<td class='centerpad7'>"+count+"</td>";
                html_code += "<td class='centerpad7'><input type='hidden' name='v_iddetbarang[]' value='"+iddet_brg+"' /><input type='hidden' name='v_kodebarang[]' value='"+kode_brg+"' /><input type='hidden' name='v_namabarang[]' value='"+nama_brg+"' />"+nama_brg+"</td>";
                html_code += "<td class='centerpad7 text-center'><input type='hidden' name='v_jumlah[]' value='"+jml_brg+"' />"+jml_brg+"</td>";
                html_code += "<td class='centerpad7'><input type='hidden' id='v_hpp[]' name='v_hpp[]' value='"+hpp+"'>\n\
                        <input type='hidden' id='v_harga[]' name='v_harga[]' value='"+harga_brg+"'>"+harga_brg+"</td>";
                html_code += "<td class='centerpad7 text-right'><input class='v_totalbk' type='hidden' id='v_totalbk[]' name='v_totalbk[]' value='"+totalhrg+"'>"+totalhrg+"</td>";
                html_code += "</tr>";  
             $('#tbl_barangkeluar').append(html_code);
             sumOfBK();
             jml = jml+1;
             $("#jml_beli").val(0);
             $("#harga").val(0);
        }        
    });  
    function sumOfBK(){
        var total = 0;
        $('.v_totalbk').each(function (index, element) {
            total = total + parseFloat($(element).val());
        });
        $("#subtotalbk").val(total);
    }

    $(document).on('click', '.remove_bk', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
        sumOfBK();
    });
    
    $('#jenisbarang').change(function(){
        $.ajaxSetup({
            type:"POST",
            url: "generateCode",
            cache: false
        });
        $.ajax({
            data:{ kode:$('#jenisbarang').val() },
            success: function(respond){                
                $('#kodebarang').val(respond)
            },
            error: function(data){
                alert('Gagal Generate Code! AJAX error!');
            }
        });
    });
});

function alertWarning(title, message) {
  $("#warning_title").html(title);
  $("#warning_message").html(message);
  $("#alert_warning").modal('show');
}