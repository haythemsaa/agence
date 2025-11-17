<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(to right, #2563eb, #1d4ed8); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .booking-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-label { font-weight: bold; color: #6b7280; }
        .detail-value { color: #111827; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .button { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmation de Réservation</h1>
            <p>Agence de Voyage Tunisie</p>
        </div>

        <div class="content">
            <p>Bonjour {{ $booking->user->name ?? $booking->holder_name ?? 'Client' }},</p>
            
            <p>Nous vous confirmons votre réservation. Voici les détails :</p>

            <div class="booking-details">
                <h3 style="margin-top: 0; color: #2563eb;">Détails de la Réservation</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Référence:</span>
                    <span class="detail-value">{{ $booking->booking_reference }}</span>
                </div>

                @if($type === 'hotel')
                    <div class="detail-row">
                        <span class="detail-label">Hôtel:</span>
                        <span class="detail-value">{{ $booking->hotel_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Destination:</span>
                        <span class="detail-value">{{ $booking->city }}, {{ $booking->country }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Check-in:</span>
                        <span class="detail-value">{{ $booking->check_in->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Check-out:</span>
                        <span class="detail-value">{{ $booking->check_out->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Voyageurs:</span>
                        <span class="detail-value">{{ $booking->nb_adults }} adulte(s)</span>
                    </div>
                @else
                    <div class="detail-row">
                        <span class="detail-label">Voyage:</span>
                        <span class="detail-value">{{ $booking->package->title }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date de départ:</span>
                        <span class="detail-value">{{ $booking->departure_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Durée:</span>
                        <span class="detail-value">{{ $booking->package->duration_days }} jours / {{ $booking->package->duration_nights }} nuits</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Participants:</span>
                        <span class="detail-value">{{ $booking->nb_adults }} adulte(s)@if($booking->nb_children > 0), {{ $booking->nb_children }} enfant(s)@endif</span>
                    </div>
                @endif

                <div class="detail-row" style="border-bottom: none; margin-top: 15px; padding-top: 15px; border-top: 2px solid #2563eb;">
                    <span class="detail-label" style="font-size: 18px;">Montant Total:</span>
                    <span class="detail-value" style="font-size: 24px; color: #2563eb; font-weight: bold;">{{ number_format($booking->total_price, 2) }} TND</span>
                </div>
            </div>

            <p style="margin-top: 30px;">
                <strong>Prochaines étapes:</strong><br>
                • Vous recevrez un voucher par email dans les 24h<br>
                • Conservez votre référence de réservation<br>
                • En cas de questions, contactez-nous
            </p>

            <center>
                <a href="{{ route('dashboard') }}" class="button">Voir ma réservation</a>
            </center>

            <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                Merci de votre confiance,<br>
                <strong>L'équipe Agence de Voyage Tunisie</strong>
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Agence de Voyage Tunisie - Tous droits réservés</p>
            <p>📞 +216 XX XXX XXX | 📧 contact@agence-voyage.tn</p>
        </div>
    </div>
</body>
</html>
