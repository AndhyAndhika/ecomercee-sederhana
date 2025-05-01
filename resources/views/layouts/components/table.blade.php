<div class="table-responsive">
    <table id="Table{{ $id }}" class="table table-hover table-bordered w-100 {{ $tableClass ?? '' }}">
        <thead class="{{ $theadClass ?? 'table-primary text-capitalize' }}">
            {{ $thead }}
        </thead>
        <tbody>
           {{ $tbody ?? '' }}
        </tbody>
    </table>
</div>
