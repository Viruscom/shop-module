@if(!$isInFavoriteProducts)
    <form class="prod-fav-form" action="{{ route('shop.registered_user.account.favorites.store', ['languageSlug' => $languageSlug, 'id' => $basketProductId]) }}" method="post">
        @csrf
        <button type="submit" class="prod-fav prod-fav-blue" onclick="$(this).closest('form').submit();"></button>
    </form>
@endif

@if($isInFavoriteProducts)
    <form class="prod-fav-form" action="{{ route('shop.registered_user.account.favorites.delete', ['languageSlug' => $languageSlug, 'id' => $basketProductId]) }}" method="POST">
        @csrf
        <button type="submit" class="prod-fav prod-fav-blue active" onclick="$(this).closest('form').submit();"></button>
    </form>
@endif
