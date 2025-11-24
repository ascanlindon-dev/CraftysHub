<<<<<<< HEAD
<?php
// Simple product view page
if (!isset($product) || !$product) {
    echo '<h2>Product not found.</h2>';
    return;
}
?>
<div style="max-width: 520px; margin: 40px auto; padding: 0; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.09); background: linear-gradient(135deg,#f8fafc 60%,#e3f0ff 100%); overflow: hidden;">
    <div style="padding: 28px 32px 20px 32px;">
        <div style="font-size: 1.1em; color: #007bff; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 18px;">Bags &amp; Clutches</div>
        <h2 style="font-size: 2em; margin-bottom: 12px; color: #222; font-weight: 700; letter-spacing: 0.5px; text-shadow: 0 1px 0 #fff;">
            <?= htmlspecialchars($product->product_name) ?>
        </h2>
        <?php if (!empty($product->image_url)): ?>
            <div style="width:100%;text-align:center;margin-bottom:18px;">
                <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->product_name) ?>" style="width: 100%; max-width: 320px; height: auto; object-fit: cover; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07);">
            </div>
        <?php endif; ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="font-size: 1.15em; color: #333; font-weight: 600; margin-bottom: 2px;">
                <span style="background: linear-gradient(90deg,#007bff,#00c6ff); color: #fff; border-radius: 6px; padding: 4px 12px; font-size: 1em; font-weight: 700; box-shadow: 0 1px 4px rgba(0,0,0,0.07);">Price: ₱<?= number_format($product->price, 2) ?></span>
            </div>
            <div style="font-size: 1em; color: #444; margin-bottom: 2px;">
                <strong>Description:</strong> <?= htmlspecialchars($product->description ?? 'No description.') ?>
            </div>
            <div style="font-size: 1em; color: #444;">
                <strong>Stock:</strong> <?= $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' ?>
            </div>
        </div>
    </div>
</div>
<hr style="max-width:500px;margin:32px auto;border:0;border-top:1.5px solid #e0e0e0;">

<div style="max-width: 500px; margin: 24px auto; padding: 24px; border: 1px solid #eee; border-radius: 12px; background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
    <h3 style="font-size: 1.4em; margin-bottom: 16px; color: #333;">Reviews & Ratings</h3>
    <?php if (!empty($review_msg)): ?>
        <div style="color: green; margin-bottom: 12px; font-weight: 500; animation: fadeIn 1s;"><?= htmlspecialchars($review_msg) ?></div>
    <?php endif; ?>
    <div id="reviews-list">
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $r): ?>
            <div style="border-bottom: 1px solid #eee; padding: 12px 0; transition: background 0.3s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                <strong style="color:#007bff;"><?= htmlspecialchars(isset($r->reviewer_name) ? $r->reviewer_name : 'User') ?></strong>
                <span style="margin-left:8px; color: #f5b50a; font-size: 1.2em;">
                    <?= str_repeat('★', $r->rating) . str_repeat('☆', 5 - $r->rating) ?>
                </span>
                <br>
                <span style="display:inline-block; margin: 6px 0 2px 0;"><strong>Review:</strong> <?= htmlspecialchars($r->review) ?></span>
                <br>
                <span style="font-size: 0.9em; color: #888;">Posted on <?= date('M d, Y H:i', strtotime($r->created_at)) ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>No reviews yet.</div>
    <?php endif; ?>
    </div>

    <h4 style="margin-top: 28px; font-size: 1.1em; color: #444;">Add Your Review</h4>
    <form method="POST" style="display: flex; flex-direction: column; gap: 12px; margin-top: 8px;" id="reviewForm">
        <label style="font-weight:500;">Rating:</label>
        <div id="starRating" style="display: flex; gap: 6px; font-size: 1.6em; cursor: pointer;">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" data-value="<?= $i ?>" style="color: #ccc; transition: color 0.2s;">★</span>
            <?php endfor; ?>
            <input type="hidden" name="rating" id="ratingInput" required>
        </div>
        <label style="font-weight:500;">Review:</label>
        <textarea name="review" rows="3" style="width: 100%; border-radius: 6px; border: 1px solid #ddd; padding: 8px;" required></textarea>
</button>
        <button type="submit" name="review_submit" style="background: linear-gradient(90deg,#007bff,#00c6ff); color: #fff; border: none; padding: 10px 0; border-radius: 6px; font-weight: 600; font-size: 1em; box-shadow: 0 1px 4px rgba(0,0,0,0.07); transition: background 0.2s;">Submit Review</button>
    </form>
    <div style="margin-top: 16px; text-align: left;">
        <a href="/buyer/products" style="color: #007bff; text-decoration: underline; font-size: 1em;">&larr; Back to Products</a>
    </div>
</div>
<hr style="max-width:500px;margin:32px auto;border:0;border-top:1.5px solid #e0e0e0;">
</div>

<style>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.star.selected, .star.hovered { color: #f5b50a !important; }
.star { user-select: none; }
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
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    if (!ratingInput.value) {
        alert('Please select a rating.');
        e.preventDefault();
    }
});
</script>
=======
<?php
// Simple product view page
if (!isset($product) || !$product) {
    echo '<h2>Product not found.</h2>';
    return;
}
?>
<div style="max-width: 520px; margin: 40px auto; padding: 0; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.09); background: linear-gradient(135deg,#f8fafc 60%,#e3f0ff 100%); overflow: hidden;">
    <div style="padding: 28px 32px 20px 32px;">
        <div style="font-size: 1.1em; color: #007bff; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 18px;">Bags &amp; Clutches</div>
        <h2 style="font-size: 2em; margin-bottom: 12px; color: #222; font-weight: 700; letter-spacing: 0.5px; text-shadow: 0 1px 0 #fff;">
            <?= htmlspecialchars($product->product_name) ?>
        </h2>
        <?php if (!empty($product->image_url)): ?>
            <div style="width:100%;text-align:center;margin-bottom:18px;">
                <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->product_name) ?>" style="width: 100%; max-width: 320px; height: auto; object-fit: cover; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07);">
            </div>
        <?php endif; ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="font-size: 1.15em; color: #333; font-weight: 600; margin-bottom: 2px;">
                <span style="background: linear-gradient(90deg,#007bff,#00c6ff); color: #fff; border-radius: 6px; padding: 4px 12px; font-size: 1em; font-weight: 700; box-shadow: 0 1px 4px rgba(0,0,0,0.07);">Price: ₱<?= number_format($product->price, 2) ?></span>
            </div>
            <div style="font-size: 1em; color: #444; margin-bottom: 2px;">
                <strong>Description:</strong> <?= htmlspecialchars($product->description ?? 'No description.') ?>
            </div>
            <div style="font-size: 1em; color: #444;">
                <strong>Stock:</strong> <?= $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' ?>
            </div>
        </div>
    </div>
</div>
<hr style="max-width:500px;margin:32px auto;border:0;border-top:1.5px solid #e0e0e0;">

<div style="max-width: 500px; margin: 24px auto; padding: 24px; border: 1px solid #eee; border-radius: 12px; background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
    <h3 style="font-size: 1.4em; margin-bottom: 16px; color: #333;">Reviews & Ratings</h3>
    <?php if (!empty($review_msg)): ?>
        <div style="color: green; margin-bottom: 12px; font-weight: 500; animation: fadeIn 1s;"><?= htmlspecialchars($review_msg) ?></div>
    <?php endif; ?>
    <div id="reviews-list">
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $r): ?>
            <div style="border-bottom: 1px solid #eee; padding: 12px 0; transition: background 0.3s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                <strong style="color:#007bff;"><?= htmlspecialchars(isset($r->reviewer_name) ? $r->reviewer_name : 'User') ?></strong>
                <span style="margin-left:8px; color: #f5b50a; font-size: 1.2em;">
                    <?= str_repeat('★', $r->rating) . str_repeat('☆', 5 - $r->rating) ?>
                </span>
                <br>
                <span style="display:inline-block; margin: 6px 0 2px 0;"><strong>Review:</strong> <?= htmlspecialchars($r->review) ?></span>
                <br>
                <span style="font-size: 0.9em; color: #888;">Posted on <?= date('M d, Y H:i', strtotime($r->created_at)) ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>No reviews yet.</div>
    <?php endif; ?>
    </div>

    <h4 style="margin-top: 28px; font-size: 1.1em; color: #444;">Add Your Review</h4>
    <form method="POST" style="display: flex; flex-direction: column; gap: 12px; margin-top: 8px;" id="reviewForm">
        <label style="font-weight:500;">Rating:</label>
        <div id="starRating" style="display: flex; gap: 6px; font-size: 1.6em; cursor: pointer;">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" data-value="<?= $i ?>" style="color: #ccc; transition: color 0.2s;">★</span>
            <?php endfor; ?>
            <input type="hidden" name="rating" id="ratingInput" required>
        </div>
        <label style="font-weight:500;">Review:</label>
        <textarea name="review" rows="3" style="width: 100%; border-radius: 6px; border: 1px solid #ddd; padding: 8px;" required></textarea>
</button>
        <button type="submit" name="review_submit" style="background: linear-gradient(90deg,#007bff,#00c6ff); color: #fff; border: none; padding: 10px 0; border-radius: 6px; font-weight: 600; font-size: 1em; box-shadow: 0 1px 4px rgba(0,0,0,0.07); transition: background 0.2s;">Submit Review</button>
    </form>
    <div style="margin-top: 16px; text-align: left;">
        <a href="/buyer/products" style="color: #007bff; text-decoration: underline; font-size: 1em;">&larr; Back to Products</a>
    </div>
</div>
<hr style="max-width:500px;margin:32px auto;border:0;border-top:1.5px solid #e0e0e0;">
</div>

<style>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.star.selected, .star.hovered { color: #f5b50a !important; }
.star { user-select: none; }
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
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    if (!ratingInput.value) {
        alert('Please select a rating.');
        e.preventDefault();
    }
});
</script>
>>>>>>> da170f7 (sure to?)
