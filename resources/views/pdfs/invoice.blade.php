<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture - {{ $payment->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background: #1e40af; color: white; padding: 30px; text-align: center; }
        .company-info { text-align: center; margin: 20px 0; }
        .invoice-details { margin: 30px 0; }
        .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .details-table th, .details-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .details-table th { background: #f9fafb; font-weight: bold; }
        .total-section { margin-top: 30px; text-align: right; }
        .total-amount { font-size: 24px; font-weight: bold; color: #1e40af; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 2px solid #e5e7eb; font-size: 12px; color: #6b7280; text-align: center; }
        .payment-info { background: #f3f4f6; padding: 15px; margin: 20px 0; border-left: 4px solid #10b981; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
        <p>Numéro: #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="company-info">
        <h2>Agence de Voyage Tunisie</h2>
        <p>📧 contact@agence-voyage.tn | 📞 +216 XX XXX XXX</p>
        <p>www.agence-voyage.tn</p>
    </div>

    <div class="invoice-details">
        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%;">
                    <strong>Facturé à:</strong><br>
                    @if($booking->user)
                        {{ $booking->user->name }}<br>
                        {{ $booking->user->email }}<br>
                        {{ $booking->user->phone ?? 'N/A' }}
                    @elseif(isset($booking->contact_name))
                        {{ $booking->contact_name }}<br>
                        {{ $booking->contact_email }}<br>
                        {{ $booking->contact_phone }}
                    @else
                        {{ $booking->holder_name ?? 'Client' }}<br>
                        {{ $booking->holder_email ?? 'N/A' }}<br>
                        {{ $booking->holder_phone ?? 'N/A' }}
                    @endif
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Date de la Facture:</strong> {{ $generated_at->format('d/m/Y') }}<br>
                    <strong>Référence Réservation:</strong> {{ $booking->booking_reference }}<br>
                    <strong>Méthode de Paiement:</strong> {{ ucfirst($payment->payment_method) }}
                </td>
            </tr>
        </table>
    </div>

    <h3>Détails de la Réservation</h3>
    <table class="details-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Détails</th>
                <th style="text-align: right;">Montant</th>
            </tr>
        </thead>
        <tbody>
            @if($payment->booking_type === 'hotel_booking')
                <tr>
                    <td><strong>Réservation Hôtel</strong></td>
                    <td>
                        {{ $booking->hotel_name }}<br>
                        <small>{{ $booking->city }}, {{ $booking->country }}</small><br>
                        <small>{{ $booking->check_in->format('d/m/Y') }} - {{ $booking->check_out->format('d/m/Y') }}</small><br>
                        <small>{{ $booking->nb_adults }} adulte(s), {{ $booking->nb_children }} enfant(s)</small>
                    </td>
                    <td style="text-align: right;">{{ number_format($booking->total_price, 2) }} TND</td>
                </tr>
            @else
                <tr>
                    <td><strong>Voyage Organisé</strong></td>
                    <td>
                        {{ $booking->package->title }}<br>
                        <small>{{ ucfirst($booking->package->type) }} - {{ $booking->package->destination }}</small><br>
                        <small>Départ: {{ $booking->departure_date->format('d/m/Y') }}</small><br>
                        <small>{{ $booking->package->duration_days }}J / {{ $booking->package->duration_nights }}N</small><br>
                        <small>{{ $booking->nb_adults }} adulte(s), {{ $booking->nb_children }} enfant(s)</small>
                    </td>
                    <td style="text-align: right;">{{ number_format($booking->total_price, 2) }} TND</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="payment-info">
        <p><strong>Statut du Paiement:</strong> 
            <span style="color: {{ $payment->status === 'completed' ? '#10b981' : '#f59e0b' }};">
                {{ $payment->status === 'completed' ? '✓ PAYÉ' : 'EN ATTENTE' }}
            </span>
        </p>
        <p><strong>Date du Paiement:</strong> {{ $payment->created_at->format('d/m/Y à H:i') }}</p>
        @if($payment->transaction_id)
            <p><strong>ID Transaction:</strong> {{ $payment->transaction_id }}</p>
        @endif
    </div>

    <div class="total-section">
        <p style="font-size: 14px; color: #6b7280;">Sous-total: <strong>{{ number_format($payment->amount, 2) }} TND</strong></p>
        <p style="font-size: 14px; color: #6b7280;">TVA (incluse): <strong>0.00 TND</strong></p>
        <hr style="margin: 10px 0;">
        <p class="total-amount">TOTAL: {{ number_format($payment->amount, 2) }} TND</p>
    </div>

    <div class="footer">
        <p><strong>Conditions de Paiement:</strong></p>
        <p style="margin: 10px 0; font-size: 11px;">
            Cette facture est générée automatiquement et ne nécessite pas de signature.<br>
            Pour toute question, veuillez nous contacter à contact@agence-voyage.tn<br>
            Merci de votre confiance!
        </p>
        
        <p style="margin-top: 30px; font-size: 10px;">
            <strong>Agence de Voyage Tunisie</strong> - Tous droits réservés © {{ date('Y') }}<br>
            Document généré le {{ $generated_at->format('d/m/Y à H:i:s') }}
        </p>
    </div>
</body>
</html>
