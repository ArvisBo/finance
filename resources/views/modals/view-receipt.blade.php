<!-- resources/views/modals/view-receipt.blade.php -->

@if($record->receipt_image)
    <img src="{{ Storage::url($record->receipt_image) }}" alt="Receipt Image" style="max-width: 100%; height: auto;">
@else
    <p>No receipt image available.</p>
@endif
