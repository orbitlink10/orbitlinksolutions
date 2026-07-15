<table class="keyword-table">
    <thead>
        <tr>
            <th>Keyword</th>
            <th class="numeric">KD <span title="Keyword Difficulty">i</span></th>
            <th class="numeric">Volume <i class="fas fa-arrow-down"></i></th>
            <th class="numeric">Traffic</th>
            <th class="numeric">CPC</th>
            <th class="numeric">Updated</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $row)
            <tr>
                <td class="keyword-cell">
                    <strong>{{ $row['keyword'] }}</strong>
                    <span>{{ $row['intent'] }} intent</span>
                </td>
                <td class="numeric">
                    <span class="kd-badge kd-{{ $row['kd_class'] }}">{{ $row['kd_label'] }}</span>
                </td>
                <td class="numeric">{{ $row['volume_label'] }}</td>
                <td class="numeric">{{ number_format($row['traffic']) }}</td>
                <td class="numeric">${{ number_format($row['cpc'], 2) }}</td>
                <td class="numeric">{{ $row['updated'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted p-4">No keyword ideas found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
