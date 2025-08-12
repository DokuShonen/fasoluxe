<section class="hero">
    <div class="hero-content">
        <h1>Votre sejour de reve commence ici</h1>
        <p>Reservez dans nos hotels de luxe au Burkina Faso</p>
    </div>
</section>

<div class="container">
    <div class="booking-form-container">
        <form action="<?php echo BASE_URL; ?>public/availability.php" method="POST" class="booking-form">
            <div class="form-group">
                <label for="date_arrivee">Arrivee</label>
                <input type="date" id="date_arrivee" name="date_arrivee" required>
            </div>
            <div class="form-group">
                <label for="date_depart">Depart</label>
                <input type="date" id="date_depart" name="date_depart" required>
            </div>
            <div class="form-group">
                <label for="ville">Ville</label>
                <select id="ville" name="ville">
                    <option value="">Toutes les villes</option>
                    <option value="Ouagadougou">Ouagadougou</option>
                    <option value="Bobo-Dioulasso">Bobo-Dioulasso</option>
                </select>
            </div>
            <div class="form-group">
                <label for="personnes">Personnes</label>
                <input type="number" id="personnes" name="personnes" value="1" min="1" max="5" required>
            </div>
            <button type="submit" class="btn">Verifier la disponibilite</button>
        </form>
    </div>

    <div class="main-content">
        <h2 class="page-title">Decouvrez FasoLuxe Hotels</h2>
        <p style="text-align:center;">Le luxe et le confort au coeur du pays des hommes intègres.</p>
    </div>
</div>