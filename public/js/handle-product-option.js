$(function () {
    //Gestion des option d'un article
    (function(){

        //Ajout des champs de l'option
        $('#add-option-item').click(function(){

            const index = +$('#option-items-counter').val();

            const optionTemplate = $('#product_option_productOptionFields').data('prototype').replace(/__name__/g, index);

            $('#product_option_productOptionFields').append(optionTemplate);

            $('#option-items-counter').val(index + 1);
            
        });
        
        //gestion du button supprimer des option
        $(document).on('click','button[data-action="delete_option_item"]',function(){
            const target = this.dataset.target;
            $(target).remove();
        })
        /*
        function handleDeleteButtons(){
            $('button[data-action="delete_option_item"]').click(function(){
                alert('test');
                const target = this.dataset.target;
                $(target).remove();
            })
        }
        handleDeleteButtons();
        */

        //Mis à jour de l'index s'il y'a déjà d'option (en cas d'édition)
        function updateIndex(){
            const counter = +$('#product_option_productOptionFields div.optionField-group').length
            $('#option-items-counter').val(counter);
        }
        updateIndex();

    }());
    
});
