<form action="{{ route('order.store') }}" method="POST">
    @csrf

    <!-- Address -->
    <div class="mb-3">
        <label for="adres" class="form-label">Adres</label>
        <input type="text" class="form-control" id="adres" name="adres" required>
    </div>

    <!-- Woonplaats -->
    <div class="mb-3">
        <label for="woonplaats" class="form-label">Woonplaats</label>
        <input type="text" class="form-control" id="woonplaats" name="woonplaats" required>
    </div>

    <!-- Telefoonnummer -->
    <div class="mb-3">
        <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
        <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Plaats Bestelling</button>
</form>
