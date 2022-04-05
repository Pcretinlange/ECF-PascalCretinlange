    $(document).ready(function (){
    datepicker('.startdate', {
        id:1,
        formatter: (input, date) => {
            input.value = date.toLocaleDateString()
        },
        startDay: 1,
        customDays : ['Di' , 'Lu' , 'Ma' , 'Me' , 'Je' , 'Ve' , 'Sa'],
        customMonths: ['Janvier' , 'Février' , 'Mars' , 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Août' , 'Septembre' , 'Octobre' , 'Novembre' , 'Décembre'],
        overlayButton : 'Valider',
        overlayPlaceholder : 'Année',
        minDate : new Date(Date.now())
    })
    datepicker('.enddate', {
    id:1,
    formatter: (input, date) => {
    input.value = date.toLocaleDateString()
}
});
});

    const $hotel = $("#reservation_form_hotels");
    $hotel.change(function (){
    let $form = $(this).closest('form');
    let data = {};
    data[$hotel.attr('name')] = $hotel.val();

    $.ajax({
    url:$form.attr('action'),
    type:$form.attr('method'),
    data:data,
    complete: function(html) {
    $("#reservation_form_hotelRooms").replaceWith(
    $(html.responseText).find("#reservation_form_hotelRooms")
    );
}
});
});
    const $idForm = $("#idReservation");
    $idForm.submit(function(e) {
        e.preventDefault();
        let data = $idForm.serialize();
        $.ajax({
            url: $idForm.attr('action'),
            type: $idForm.attr('method'),
            data: data,
            complete: function(html) {
                $("#result").replaceWith(
                    $(html.responseText).find("#result")
                );
            }
        });
    });
