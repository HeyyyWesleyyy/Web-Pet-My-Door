$(document).ready(function(){
    $("#cpfcnpj").keydown(function(){
        try{
            $("#cpfcnpj").unmask();
        } catch (e) {}
        var tamanho = $("#cpfcnpj").val().length;
        if(tamanho < 11){
            $("#cpfcnpj").mask("000.000.000-00");
        } else {
            $("#cpfcnpj").mask("00.000.000/0000-00");
        }
        var elem = this;
        setTimeout(function(){
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
    $("#telefone").keydown(function(){
        try{
            $("#telefone").unmask();
        } catch (e) {}
        var tamanho = $("#telefone").val().length;
        if(tamanho < 10){
            $("#telefone").mask("(00) 0000-0000");
        } else {
            $("#telefone").mask("(00) 00000-0000");
        }
        var elem = this;
        setTimeout(function(){
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
    $("#email").mask("A", {
        translation: {
            "A": { pattern: /[\w@\-.+]/, recursive: true }
        }
    });
});