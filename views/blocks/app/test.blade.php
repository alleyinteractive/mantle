<p>This is an example of a block using a blade template.</p>

@for ($i = 0; $i < 10; $i++)
    <p>The current value is {{ $i }}</p>
@endfor
