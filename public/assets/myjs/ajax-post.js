$(document).ready(function() {

    $('#iBarcode').focus();

});

$(document).scannerDetection({
timeBeforeScanTest: 200, // wait for the next character for upto 200ms
avgTimeByChar: 100, // it's not a barcode if a character takes longer than 100ms
onComplete: function(barcode, qty) {

    $('#iBarcode').text(barcode);
    var url = $("#quickForm").attr('class');
    $.ajax({
        type: 'get',
        url: url,
        data: 'rowid=' + barcode, //Pass $id
        success: function (data) {

            var  exists = JSON.stringify(data['exists']);

            if (exists !=0) {

                $('#subject').html("<div class='alert alert-danger btn-xs'>"+'This Product '+ exists.replace(/"/g, "")+' Qty already added,U wanna to continue ?'+"</div>");
                $("#subject").show().delay(4000).fadeOut();
            }
            var  myJSON = JSON.stringify(data['data']);
            var array = $.parseJSON(myJSON);

            if ($.trim(array[0])){

                if ($.trim(array[0]['item_code']) && $.trim(array[0]['item_name']) && $.trim(array[0]['price']) && $.trim(array[0]['unit']) !== ""){
                    $('#iBarcode').val(array[0]['item_code']);
                    $('#itemname').val(array[0]['item_name']);
                    $('#unit').val(array[0]['unit']);
                    $('#price').val(array[0]['price']);
                    $('#system_stock').val(array[0]['stock']);
                    $('#phy_stock').val(1);
                    $('#phy_stock').focus();
                }
                else {
                    $('#iBarcode').css('color','red');
                    $('#iBarcode').val('Some fields are miss of this barcode, Please call system Admin');
                }
            }
            else {
                $('#form_id')[0].reset();
            }
        }
    });

} // main callback function
});

$(document).ready(function() {

    $( "#target" ).click(function() {
        var name = $('#iBarcode').val();
        var url = $("#target").attr('name');
        $.ajax({
            type: "get",
            url: url,
            data: { search: name },
            success: function(html) {
                $("#key_display").html(html).show();
            }
        });
    });
});

function fill(data) {

    var url = $("#submit").attr('name');
    var response = data.split(",");
    if ($.trim( response[0]) && $.trim( response[1]) && $.trim( response[2]) && $.trim( response[3]) !== ""){
        $('#iBarcode').val(response[0]);
        $('#itemname').val(response[1]);
        $('#unit').val(response[2]);
        $('#price').val(response[3]);
        $('#system_stock').val(response[4]);
        $('#phy_stock').val(1);
        $('#phy_stock').focus();
    }
    else {
        $('#iBarcode').css('color','red');
        $('#iBarcode').val('Some fields are miss of this barcode, Please call system Admin');
    }

    $.ajax({
        type: "get",
        url: url,
        data: { search: response[0]},
        success: function(res) {
            if (res !=0) {

                $('#subject').html("<div class='alert alert-danger btn-xs'>"+'This Product '+res+' Qty already added,U wanna to continue ?'+"</div>");
                $("#subject").show().delay(3000).fadeOut();
            }
        }
    });

}

$(document).on('click', function (e) {

    $("#key_display").hide();

});

