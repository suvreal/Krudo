

/**
 * Imports of JS modules/files
 */
import * as searchProducts from './searchProducts.js';


/**
 * Process DOM Javascript events
 */
$(document).ready(function() {
    /**
     * Catch events: search products
     */
    searchProducts.processSearchEvent();
});

