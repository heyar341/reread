// ラジオボタングループ(name)ごとにプロパティを定義、初期化しておく
var checkedRadioValue = { 'prof_image': ''};

$('input[type="radio"]').on('click', function() {
    var name = $(this).attr('name');
    var value = $(this).val();

    if (checkedRadioValue[name] === value) {
        checkedRadioValue[name] = '';
        $(this).prop('checked', false);
    } else {
        checkedRadioValue[name] = value;
    }
});
