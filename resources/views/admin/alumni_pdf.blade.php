<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>All Alumni Profiles</title>

    <style>

        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 13px;
        }

        .generated {
            text-align: right;
            font-size: 8px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

    </style>

</head>

<body>

<div class="header">

    <h2>
        ALUMNI MANAGEMENT AND INFORMATION RETRIEVAL SYSTEM
    </h2>

    <h3>
        COMPLETE ALUMNI PROFILE LIST
    </h3>

</div>

<div class="generated">

    Date Generated:
    {{ now()->format('d F Y, h:i A') }}

</div>


<table>

    <thead>

        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Department</th>
            <th>Graduation Year</th>
            <th>Current Address</th>
            <th>Bio</th>
        </tr>

    </thead>


    <tbody>

        @forelse($profiles as $index => $profile)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $profile->user->name ?? 'N/A' }}
                </td>

                <td>
                    {{ $profile->user->email ?? 'N/A' }}
                </td>

                <td>
                    {{ $profile->phone ?? 'N/A' }}
                </td>

                <td>
                    {{ ucfirst($profile->gender ?? 'N/A') }}
                </td>

                <td>

                    @if($profile->dob)

                        {{ \Carbon\Carbon::parse($profile->dob)->format('d M Y') }}

                    @else

                        N/A

                    @endif

                </td>

                <td>
                    {{ $profile->department->department ?? 'N/A' }}
                </td>

                <td class="center">
                    {{ $profile->graduation_year ?? 'N/A' }}
                </td>

                <td>
                    {{ $profile->current_address ?? 'N/A' }}
                </td>

                <td>
                    {{ $profile->bio ?? 'N/A' }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="10" class="center">

                    No alumni profiles found.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>

</body>
</html>