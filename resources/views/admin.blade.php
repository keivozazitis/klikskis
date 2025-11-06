<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite([
        'resources/css/admin.css'
    ])
</head>
<body>

    <header class="admin-header">
        <h1>Admin Panel</h1>
        <nav>
            <a href="{{ url('/') }}">Sākums</a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit">Izrakstīties</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <section class="card">
            <h2>Visi lietotāji</h2>

                                @if($users->count())
                                    <table class="user-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Vārds</th>
                                                <th>E-pasts</th>
                                                <th>Admin?</th>
                                                <th>Izveidots</th>
                                            </tr>
                                        </thead>
                                        @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge yes">Jā</span>
                            @else
                                <span class="badge no">Nē</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <!-- DELETE poga -->
                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies dzēst šo lietotāju?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Dzēst</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            @else
                <p class="empty">Nav lietotāju datubāzē.</p>
            @endif
        </section>
        <section class="card" style="margin-top:40px;">
            <h2>Iesniegtie ziņojumi</h2>

            @if($reports->count())
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lietotājs</th>
                            <th>Ziņotājs</th>
                            <th>Iemesls</th>
                            <th>Datums</th>
                            <th>Darbības</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->reportedUser->first_name }} {{ $report->reportedUser->last_name }}</td>
                                <td>{{ $report->reporterUser->first_name }} {{ $report->reporterUser->last_name }}</td>
                                <td>
                                    @switch($report->reason)
                                        @case('underage') Persona izskatās nepilngadīga @break
                                        @case('impersonation') Persona uzdodas par kādu citu @break
                                        @case('pornographic') Pornogrāfisks saturs @break
                                    @endswitch
                                </td>
                                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <!-- Dzēst report -->
                                    <form action="{{ route('admin.report.delete', $report->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies dzēst šo reportu?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Dzēst</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">Nav iesniegto reportu.</p>
            @endif
        </section>

    </main>

    <footer class="admin-footer">
    </footer>

</body>
</html>
