<div>
    @if($type == 'product')
    <livewire:frontend.product.details :slug="$slug">
    @elseif($type == 'category')
    <livewire:frontend.category :slug="$slug">
    @endif
</div>
