<?php
// Simple product view page
if (!isset($product) || !$product) {
    echo '<h2>Product not found.</h2>';
    return;
}
?>
<div class="product-container">
    <div class="product-card">
        <div class="product-category">Bags &amp; Clutches</div>
        <h2 class="product-name"> <?= htmlspecialchars($product->product_name) ?> </h2>
        <?php if (!empty($product->image_url)): ?>
            <div class="product-image">
                <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->product_name) ?>">
            </div>
        <?php endif; ?>
        <div class="product-details">
            <div class="product-price">₱<?= number_format($product->price, 2) ?></div>
            <div class="product-description"><strong>Description:</strong> <?= htmlspecialchars($product->description ?? 'No description.') ?></div>
            <div class="product-stock"><strong>Stock:</strong> <?= $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' ?></div>
        </div>
    </div>
</div>
<hr class="divider">
<div class="reviews-container">
    <h3>Reviews & Ratings</h3>
    <?php if (!empty($review_msg)): ?>
        <div class="review-message"> <?= htmlspecialchars($review_msg) ?> </div>
    <?php endif; ?>
    <div id="reviews-list">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $r): ?>
                <div class="review-item">
                    <strong class="reviewer-name"> <?= htmlspecialchars(isset($r->reviewer_name) ? $r->reviewer_name : 'User') ?> </strong>
                    <span class="review-rating"> <?= str_repeat('★', $r->rating) . str_repeat('☆', 5 - $r->rating) ?> </span>
                    <p class="review-text"> <?= htmlspecialchars($r->review) ?> </p>
                    <span class="review-date"> Posted on <?= date('M d, Y H:i', strtotime($r->created_at)) ?> </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-reviews">No reviews yet.</div>
        <?php endif; ?>
    </div>
    <h4>Add Your Review</h4>
    <form method="POST" id="reviewForm">
        <label>Rating:</label>
        <div id="starRating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" data-value="<?= $i ?>">★</span>
            <?php endfor; ?>
            <input type="hidden" name="rating" id="ratingInput" required>
        </div>
        <label>Review:</label>
        <textarea name="review" rows="3" required></textarea>
        <button type="submit" name="review_submit" class="submit-btn">Submit Review</button>
    </form>
    <a href="/buyer/products" class="back-link">&larr; Back to Products</a>
</div>
<style>
/* General Styles */
body { font-family: "Poppins", sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
.product-container { max-width: 1200px; margin: 20px auto; padding: 20px; }
.product-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center; }
.product-category { font-size: 0.9em; color: #C88A6F; margin-bottom: 10px; }
.product-name { font-size: 1.8em; color: #2D2D2D; margin-bottom: 20px; }
.product-image img { max-width: 100%; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
.product-details { margin-top: 20px; }
.product-price { font-size: 1.5em; color: #D9967D; font-weight: bold; margin-bottom: 10px; }
.product-description, .product-stock { font-size: 1em; color: #555; margin-bottom: 10px; }
.divider { margin: 40px auto; border: 0; border-top: 1px solid #ddd; }
.reviews-container { max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
.review-item { border-bottom: 1px solid #eee; padding: 10px 0; }
.reviewer-name { color: #C88A6F; font-weight: bold; }
.review-rating { color: #f5b50a; }
.review-text { margin: 10px 0; color: #555; }
.review-date { font-size: 0.9em; color: #888; }
.no-reviews { text-align: center; color: #888; }
.submit-btn { background: linear-gradient(135deg, #D9967D, #C88A6F); color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background 0.3s; }
.submit-btn:hover { background: #C88A6F; }
.back-link { display: inline-block; margin-top: 20px; color: #D9967D; text-decoration: none; }
.back-link:hover { text-decoration: underline; }
/* Star Rating */
#starRating { display: flex; gap: 5px; font-size: 1.5em; cursor: pointer; }
.star { color: #ccc; transition: color 0.2s; }
.star.selected, .star.hovered { color: #f5b50a; }
</style>
<script>
// Interactive star rating
const stars = document.querySelectorAll('.star');
const ratingInput = document.getElementById('ratingInput');
let selectedRating = 0;
stars.forEach((star, idx) => {
    star.addEventListener('mouseover', () => {
        stars.forEach((s, i) => {
            s.classList.toggle('hovered', i <= idx);
        });
    });
    star.addEventListener('mouseout', () => {
        stars.forEach((s, i) => {
            s.classList.toggle('hovered', i < selectedRating);
        });
    });
    star.addEventListener('click', () => {
        selectedRating = idx + 1;
        ratingInput.value = selectedRating;
        stars.forEach((s, i) => {
            s.classList.toggle('selected', i < selectedRating);
            s.classList.remove('hovered');
        });
    });
});
// Prevent form submit if no rating
const reviewForm = document.getElementById('reviewForm');
reviewForm.addEventListener('submit', function(e) {
    if (!ratingInput.value) {
        alert('Please select a rating.');
        e.preventDefault();
    }
});
</script>
