var RSCAFAN = (function(window, document, $) {
    $('#fan-customer-type-company').click(function(){
        $('#hidediv').css('display','block');
    })
    $('#fan-customer-type-private').click(function(){
        $('#hidediv').css('display','none');
    })



    var settings = {
        language: 'nl'
    };

    var rscaFan = {
        init: function(){
            rscaFan.triggerCompanyFields();
            rscaFan.loadTickets();
        },

        triggerCompanyFields: function() {
            // Only show the company fields when the customer
            // tells us he/she represents a company
            if ($('input:radio[name="customer_type"]').length > 0) {
                $('input:radio[name="customer_type"]').change(function() {
                    if ($(this).val() == 'company'){
                        $('.company-fields').show();
                    } else {
                        $('.company-fields').hide();
                    }
                });
            }
        },

        setupTicketsAccordion: function() {
            $('.match-tickets:not(:first)').hide();

            $('.match-description').on('click', function() {
                $('.match-tickets').hide();
                $(this).nextAll('.match-tickets:first').show();
            });
        },

        showCateringModal: function() {
            $('.personalize-tickets').on('click', function() {
                var match      = $(this).data('match');
                var modalClass = '.personalize-tickets-' + match;

                $.pgwModal({
                    target: modalClass,
                    maxWidth: 800,
                    titleBar: false
                });

                return false;
            });

            $('body').on('click', '.close-personalize-tickets', function() {
                $.pgwModal('close');

                return false;
            });
        },

        loadTickets: function() {
            if ($('.content.tickets').length > 0) {
                // Show the overlay
                var loadingMessage = "<h1>Even geduld aub...</h1>";

                if (window.settings.language == 'fr') {
                    loadingMessage = "<h1>S'il vous plaît, attendez...</h1>";
                }

                $.blockUI({
                    message: loadingMessage,
                    css: {
                        border: 'none',
                        color: '#fff',
                        background: 'none'
                    },
                    overlayCSS: {
                        opacity: 0.7
                    }
                });

                // Get the tickets
                $.ajax({
                    url: window.settings.baseUrl + 'tickets/tickets',
                    method: 'GET',
                    dataType: 'html'
                }).done(function(data) {
                    $('.content.tickets').html(data);

                    rscaFan.setupTicketsAccordion();
                    rscaFan.showCateringModal();

                    $.unblockUI();
                });
            }
        }
    };

    $(function(){
        rscaFan.init();
    });

}(window, window.document, window.jQuery));
