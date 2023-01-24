

export function processSearchEvent(){
    /**
     * Event handling for particular View
     */
    let timeout;
    let searchInput = $("#searchInput");
    let initialProducts = $(".initial-products");
    let searchedProducts = $(".searched-products");

    searchInput.keypress(function() {
        if(event.key){
            initialProducts.addClass("display-none");
            searchedProducts.remove();
            if ($(this).val().length >= 3) {
                clearTimeout(timeout);
                setTimeout(_ => {
                    performSearchAsyncRequest($(this).val());
                }, 250);
            }
            if ($(this).val().length <= 0) {
                searchedProducts.remove();
                initialProducts.show();
            }
        }
    });

    searchInput.keypress(function() {
        if(event.key) {
            if ($(this).val().length <= 0) {
                $(".searched-products").remove();
                $(".initial-products").removeClass("display-none");
            }
        }
    });

}


/**
 * Performs async ajax post request to obtain and display products by filter search
 */
export function performSearchAsyncRequest(searchValue) {
    $(".initial-products").hide();
    $(".searched-products").remove();
    $.ajax({
        type: "POST",
        url: "/products",
        data: {
            searchProducts: searchValue
        },
        dataType: 'json',
        success: function(response) {
            let arrayValues = Object.values(response)[1];
            for (let i = 0; i < arrayValues.length; i++) {
               $('#product-data-list').append('<tr class="data-list-item products-box searched-products searched-products-record">' +
                   '<td class="data-list-item-element searched-products">' + arrayValues[i].Title + '</td>' +
                   '<td class="data-list-item-element searched-products">' + arrayValues[i].DiscountPrice + '</td>' +
                   '<td class="data-list-item-element searched-products">' + arrayValues[i].Price + '</td>' +
                   '<td class="data-list-item-element searched-products">' +
                   '<a href="/product?ID=' + arrayValues[i].ID + '">' +
                   '<span class="material-icons" title="edit record">edit_note</span></a>' +
                   '<a href="/product-delete?ID=' + arrayValues[i].ID + '">' +
                   '<span class="material-icons" title="delete record">delete</span>' +
                   '</td>' +
                   '</tr>');
            }
        },
        error: function(response) {
            console.error(response);
        }
    });
}

