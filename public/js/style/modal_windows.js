(function($) {

	//-------------------modal windows list connect to db---------------------//
	var WINDOWS_LIST_CONNECT = {
        data    : null,
		form    : '.form-horizontal',
		input   : '.form-control',
        spinner : $('#spinner'),
        button  : {
            className : 'button-test-connect',
            listStyleButton : {
                default : 'btn-primary',
                fail    : 'btn-danger',
                success : 'btn-success'
            }    
        },
        removeBtnId : '#remove-wrapper'
    };

	var objectWLC = WINDOWS_LIST_CONNECT;

	var checkEmpty = function () {
       var empty = 1; 

       $(objectWLC.form + ' ' + objectWLC.input['type=text']).each(function () {
            if (!$(this).hasClass('db-name')) {
                console.log(this);
                empty &= $.trim($(this).val()) == '' ? 0 : 1;    
            }
       });

       return  empty;
    };

    var toggleButton = function (typeButton, textButton) {
        var button = objectWLC.button,
            b      = $('.' + button.className);
     
        if (textButton == '') {
            textButton = 'OK';
        } 

        if (typeButton == '' || typeButton == undefined) {
            typeButton = button.listStyleButton.default;
        } 

        b.text(textButton);
        b.removeClass();
        b.addClass('btn');
        b.addClass(button.className);
        b.addClass(typeButton);
    };

    var toggleInputSelect = function (data) {
        var  inputObj     = $('.db-name'),
             inputDisplay = inputObj.css('display');

        if (inputDisplay == 'none') {
            $("#bs3Select option").remove(); 
            $("#bs3Select").append('<option value="">----</option>');
            $(".bootstrap-select").hide();
            inputObj.show();
        } else {
            if (data != undefined) {
                $(".bootstrap-select").show();
                $("#bs3Select option").remove(); //TODO :: rename identificator
                for (var i = 0; i < data.length; i++) {
                    $("#bs3Select").append('<option value=' + data[i] + '>' + data[i] + '</option>');
                }

                $('.selectpicker').selectpicker({
                    'selectedText': data[0]
                });

                inputObj.hide();    
            }
        }
        
    };

    var enebletInput = function (action) {
        action = action == '' || action == undefined ? false : action;
        $('#db-settings .col-lg-10 > .col-lg-3').each(function () {
            if (!$(this).hasClass('list-db-names')) {
                $(this).children('input').attr('disabled', action);
            }    
        });
    }

    var send = function() {
        var frm = $(objectWLC.form);

        objectWLC.spinner.show();
        $.ajax({
            type : frm.attr('method'),
            url  : frm.attr('action'),
            data : frm.serialize(),
            success: function (data) {
                objectWLC.spinner.hide();
                getListDb(data);
            }
        });
    };

    var getListDb = function (data) {
        var b = objectWLC.button;

        if (data == 'false') {
            toggleButton(b.listStyleButton.fail, 'Fail...');
        } else {
            data = JSON.parse(data);
            toggleButton(b.listStyleButton.success, 'Success');
            $('.' + b.className).attr('disabled','disabled');
            $('#remove-wrapper').show(); //TODO ::
            enebletInput(true);
            toggleInputSelect(data);
        }
    };

    var registerDb = function () {
        var table = $(".lis-active-connect tbody"),
            host  = $("#exampleInputHost").val(),
            user  = $("#exampleInputUser").val(),
            db    = $('.filter-option.pull-left').text(),
            count = $('.lis-active-connect >tbody >tr').length + 1;

            table.append('<tr class="success">'
                         + '<td class="count-data">' + count + '</td>'
                         + '<td class="host-data">' + host + '</td>'
                         + '<td class="user-data">' + user + '</td>'
                         + '<td class="db-data">' + db + '</td>'
                         + '<td>'
                         + '<div class="btn-toolbar" role="toolbar">'
                         + '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>'
                         + '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></button>'
                         + '</div>'
                         + '</td></tr>');

        $('.dropdown-menu .dropdown-menu li').each(function () {
            if ($(this).hasClass('selected')) {
                $(this).remove();
            }});
    };


    //-----------------------------------------------------------------------------
    $(objectWLC.removeBtnId).click(function () {
        enebletInput(false);
        toggleButton(objectWLC.button.listStyleButton.default, 'Test');
        toggleInputSelect();
        $('.' + objectWLC.button.className).attr('disabled',false);
        $(this).hide();
    });

	$('.form-control').keyup(function () {
        var button = $(objectWLC.form + '  .' + objectWLC.button.className);

        checkEmpty() ? button.attr('disabled',false) : button.attr('disabled','disabled');
	});

    $(objectWLC.form + '  .' + objectWLC.button.className).click(function() {send(true);});

    $("#bs3Select").change(function () {
        registerDb();
    });

    var form_create_display_db = $('form', {id: 'form-create-display-db'});

    $('#create-display-db').click(function () {
        //console.log(form_create_display_db);
        var arr_alements = {
            hosts : [],
            user  : [],
            db    : []
        };

        $('.lis-active-connect tbody .success').find('td').each(function () {
            if (this.className == 'host-data') {
                arr_alements.hosts.push($(this).html());
            } else if (this.className == 'user-data') {
                arr_alements.user.push($(this).html());
            } else if (this.className == 'db-data') {
                arr_alements.db.push($(this).html());
            }
        });

        console.log(arr_alements);
    });
})(jQuery);
