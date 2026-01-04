<style>
    .seat-box {
        width: 70px;
        height: 55px;
        border-radius: 8px;
        margin: 6px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        cursor: pointer;
        color: #fff;
    }

    .available {
        background: #28a745;
    }

    .booked {
        background: #dc3545;
        cursor: not-allowed;
    }

    .reserved {
        background: #ffc107;
        color: #000;
    }

    .blocked {
        background: #6c757d;
    }

    .selected {
        border: 3px solid #000;
    }
</style>

<h5>Select Seat</h5>

<div class="d-flex flex-wrap">
    @foreach ($seats as $seat)
        <div class="seat-box {{ $seat->status }}"
             data-id="{{ $seat->seat_id }}"
             onclick="selectBookingSeat(this)">
            {{ $seat->seat->seat_number }}
        </div>
    @endforeach
</div>

<script>
    window.selectBookingSeat = function(el) {
        if ($(el).hasClass('booked')) return;

        $('.seat-box').removeClass('selected');
        $(el).addClass('selected');

        // remove previous hidden seat_id if exists
        $('#bookingForm input[name="seat_id"]').remove();

        // add new hidden seat_id
        $('<input>', {
            type: 'hidden',
            name: 'seat_id',
            value: $(el).data('id')
        }).appendTo('#bookingForm');
    }
</script>