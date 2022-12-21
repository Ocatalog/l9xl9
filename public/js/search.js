var filtro = document.getElementById('name_hunter');
var tabela = document.getElementById('search_hunter');

filtro.onkeyup = function() {
    var nomeFiltro = filtro.value.toLowerCase();
    for (var i = 1; i < tabela.rows.length; i++) {
        var conteudoCelula = tabela.rows[i].cells[1].innerText;
        var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
        tabela.rows[i].style.display = corresponde ? '' : 'none';
    }
}
