PHP files that handle the app's actions:

- login.php, register.php, logout.php -> login / register / logout (session)

The cart and favorites are linked to the `cart` and `favorites` tables in the
database through AJAX (fetch) requests from `assets/js/common.js` (shared
functions like addToCart/addToFav), `assets/js/cart-page.js` and
`assets/js/fav-page.js`. All of these files return a JSON response, and they
all require the user to be logged in (`$_SESSION['user_id']`) - if not, they
return `needLogin: true`:

- cart_add.php -> adds a product to the cart (or increases its quantity if it's already there)
- cart_update.php -> increases/decreases a product's quantity in the cart (`op=increase` or `op=decrease`)
- cart_remove.php -> removes a product from the cart
- cart_clear.php -> empties the whole cart
- get_cart.php -> returns all cart items (GET) with product data (title, price, img)

- fav_toggle.php -> adds/removes a product from favorites (toggle)
- fav_remove.php -> removes a specific product from favorites
- fav_clear.php -> empties favorites completely
- get_fav.php -> returns all favorite items (GET) with product data

- contact_submit.php -> saves a message from pages/contact.php into the `contacts` table
- place_order.php -> creates an order from the user's cart: inserts a row into
  `orders` and one row per item into `order_items`, then clears the cart

Note: the products on the home page (index.php) are still fixed (demo) data,
not from the products table, so clicking "add to cart" on them may show a
"product not available" message if the id isn't in the table. The real,
fully database-backed catalog is the shop.php page.
