$('.select-investigators').chosen(
    {
        no_results_text: "No se encontro al usuario!",
        placeholder_text_multiple: "Seleccione un investigador"
    }
);

$('.select-scholars').chosen(
    {
        no_results_text: "No se encontro al usuario!",
        placeholder_text_multiple: "Seleccione un becario",
        allow_single_deselect: false
    }
);
