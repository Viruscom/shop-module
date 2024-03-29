<form action="{{ route('shop.registered_user.account.favorites.delete', ['languageSlug' => $languageSlug, 'id' => $product->id]) }}" method="POST" style="display: inline;">
    @csrf
    <button class="prod-fav active"></button>
</form>
