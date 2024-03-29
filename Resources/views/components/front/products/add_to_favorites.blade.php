<form action="{{ route('shop.registered_user.account.favorites.store', ['languageSlug' => $languageSlug, 'id' => $product->id]) }}" method="post" class="d-inline-block">
    @csrf
    <button class="prod-fav"></button>
</form>
