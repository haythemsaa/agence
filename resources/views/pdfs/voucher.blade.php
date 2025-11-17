<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Voucher - {{ $booking->booking_reference }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; }
        .booking-info { margin: 20px 0; padding: 15px; background: #f3f4f6; border-left: 4px solid #2563eb; }
        .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .details-table th, .details-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .details-table th { background: #f9fafb; font-weight: bold; }
        .total { font-size: 20px; font-weight: bold; color: #2563eb; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; font-size: 12px; color: #6b7280; }
        .qr-code { text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>VOUCHER DE RÉSERVATION</h1>
        <p>Agence de Voyage Tunisie</p>
    </div>

    <div class="content">
        <div class="booking-info">
            <h2 style="margin-top: 0;">Référence: {{ $booking->booking_reference }}</h2>
            <p><strong>Date d'émission:</strong> {{ $generated_at->format('d/m/Y H:i') }}</p>
            <p><strong>Statut:</strong> {{ strtoupper($booking->status) }}</p>
        </div>

        @if($type === 'hotel')
            <h3>Informations de l'Hôtel</h3>
            <table class="details-table">
                <tr>
                    <th>Hôtel</th>
                    <td>{{ $booking->hotel_name }}</td>
                </tr>
                <tr>
                    <th>Adresse</th>
                    <td>{{ $booking->address ?? $booking->city }}, {{ $booking->country }}</td>
                </tr>
                <tr>
                    <th>Check-in</th>
                    <td>{{ $booking->check_in->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Check-out</th>
                    <td>{{ $booking->check_out->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Nombre de nuits</th>
                    <td>{{ $booking->check_in->diffInDays($booking->check_out) }}</td>
                </tr>
                <tr>
                    <th>Voyageurs</th>
                    <td>{{ $booking->nb_adults }} adulte(s)@if($booking->nb_children > 0), {{ $booking->nb_children }} enfant(s)@endif</td>
                </tr>
            </table>
        @else
            <h3>Informations du Voyage</h3>
            <table class="details-table">
                <tr>
                    <th>Voyage</th>
                    <td>{{ $booking->package->title }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>{{ ucfirst($booking->package->type) }}</td>
                </tr>
                <tr>
                    <th>Date de départ</th>
                    <td>{{ $booking->departure_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Durée</th>
                    <td>{{ $booking->package->duration_days }} jours / {{ $booking->package->duration_nights }} nuits</td>
                </tr>
                <tr>
                    <th>Départ de</th>
                    <td>{{ $booking->package->departure_city }}</td>
                </tr>
                <tr>
                    <th>Participants</th>
                    <td>{{ $booking->nb_adults }} adulte(s)@if($booking->nb_children > 0), {{ $booking->nb_children }} enfant(s)@endif</td>
                </tr>
            </table>
        @endif

        <h3>Informations du Client</h3>
        <table class="details-table">
            <tr>
                <th>Nom</th>
                <td>{{ $booking->user->name ?? $booking->holder_name ?? $booking->contact_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking->user->email ?? $booking->holder_email ?? $booking->contact_email }}</td>
            </tr>
            <tr>
                <th>Téléphone</th>
                <td>{{ $booking->user->phone ?? $booking->holder_phone ?? $booking->contact_phone }}</td>
            </tr>
        </table>

        <h3>Détails Financiers</h3>
        <table class="details-table">
            <tr>
                <th>Montant Total</th>
                <td class="total">{{ number_format($booking->total_price, 2) }} TND</td>
            </tr>
            @if(isset($booking->paid_amount))
                <tr>
                    <th>Montant Payé</th>
                    <td>{{ number_format($booking->paid_amount, 2) }} TND</td>
                </tr>
                <tr>
                    <th>Reste à Payer</th>
                    <td style="color: {{ $booking->remaining_amount > 0 ? '#dc2626' : '#16a34a' }};">
                        {{ number_format($booking->remaining_amount, 2) }} TND
                    </td>
                </tr>
            @endif
        </table>

        <div class="footer">
            <p><strong>Important:</strong></p>
            <ul style="margin: 10px 0;">
                <li>Présentez ce voucher lors de votre arrivée</li>
                <li>Conservez une copie électronique et une copie imprimée</li>
                <li>Vérifiez tous les détails avant votre départ</li>
                <li>Pour toute modification, contactez-nous au moins 48h à l'avance</li>
            </ul>

            <p style="margin-top: 30px;">
                <strong>Agence de Voyage Tunisie</strong><br>
                📞 +216 XX XXX XXX | 📧 contact@agence-voyage.tn<br>
                www.agence-voyage.tn
            </p>

            <p style="text-align: center; margin-top: 20px; font-size: 10px;">
                Document généré le {{ $generated_at->format('d/m/Y à H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html>
