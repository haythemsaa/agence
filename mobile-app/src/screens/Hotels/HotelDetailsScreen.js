import React, {useState, useEffect} from 'react';
import {View, Text, StyleSheet, ScrollView, TouchableOpacity, Image, Dimensions, ActivityIndicator} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';

const {width} = Dimensions.get('window');

const HotelDetailsScreen = ({route, navigation}) => {
  const {id} = route.params;
  const [hotel, setHotel] = useState(null);
  const [loading, setLoading] = useState(true);
  const [selectedImageIndex, setSelectedImageIndex] = useState(0);

  useEffect(() => {
    loadHotelDetails();
  }, [id]);

  const loadHotelDetails = async () => {
    try {
      const response = await api.hotels.getById(id);
      setHotel(response.data);
    } catch (error) {
      console.error('Error:', error);
    } finally {
      setLoading(false);
    }
  };

  const renderStars = (count) => Array(count).fill(0).map((_, i) => <Icon key={i} name="star" size={16} color={colors.star} />);

  const AmenityBadge = ({icon, label}) => (
    <View style={styles.amenityBadge}>
      <Icon name={icon} size={20} color={colors.primary} />
      <Text style={styles.amenityText}>{label}</Text>
    </View>
  );

  const amenityIcons = {
    wifi: {icon: 'wifi', label: 'WiFi'},
    piscine: {icon: 'water', label: 'Piscine'},
    spa: {icon: 'rose', label: 'Spa'},
    restaurant: {icon: 'restaurant', label: 'Restaurant'},
    plage_privee: {icon: 'sunny', label: 'Plage Privée'},
    parking: {icon: 'car', label: 'Parking'},
    kids_club: {icon: 'happy', label: 'Kids Club'},
    climatisation: {icon: 'snow', label: 'Climatisation'},
    room_service: {icon: 'concierge', label: 'Room Service'},
  };

  if (loading) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  if (!hotel) {
    return (
      <View style={styles.centerContainer}>
        <Icon name="alert-circle-outline" size={64} color={colors.lightGray} />
        <Text style={styles.errorText}>Hôtel non trouvé</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <ScrollView showsVerticalScrollIndicator={false}>
        {/* Image Gallery */}
        <View style={styles.imageContainer}>
          {hotel.images && hotel.images.length > 0 ? (
            <Image source={{uri: hotel.images[selectedImageIndex]}} style={styles.mainImage} resizeMode="cover" />
          ) : (
            <LinearGradient colors={gradients.primary} style={styles.mainImage}>
              <Icon name="business-outline" size={80} color={colors.white} />
            </LinearGradient>
          )}

          {/* Image Thumbnails */}
          {hotel.images && hotel.images.length > 1 && (
            <ScrollView horizontal style={styles.thumbnailScroll} showsHorizontalScrollIndicator={false}>
              {hotel.images.map((img, idx) => (
                <TouchableOpacity key={idx} onPress={() => setSelectedImageIndex(idx)} style={[styles.thumbnail, selectedImageIndex === idx && styles.thumbnailActive]}>
                  <Image source={{uri: img}} style={styles.thumbnailImage} />
                </TouchableOpacity>
              ))}
            </ScrollView>
          )}

          {/* Wishlist Button */}
          <TouchableOpacity style={styles.wishlistButton}>
            <Icon name="heart-outline" size={24} color={colors.white} />
          </TouchableOpacity>
        </View>

        <View style={styles.contentContainer}>
          {/* Header Info */}
          <View style={styles.headerInfo}>
            <View style={styles.titleContainer}>
              <Text style={styles.hotelName}>{hotel.name}</Text>
              <View style={styles.stars}>{renderStars(hotel.stars)}</View>
            </View>
            {hotel.is_featured && <View style={styles.featuredBadge}><Text style={styles.featuredText}>⭐ Vedette</Text></View>}
          </View>

          {/* Location */}
          <View style={styles.locationContainer}>
            <Icon name="location" size={18} color={colors.primary} />
            <Text style={styles.locationText}>{hotel.address || `${hotel.city}, ${hotel.country}`}</Text>
          </View>

          {/* Rating */}
          {hotel.rating > 0 && (
            <View style={styles.ratingContainer}>
              <View style={styles.ratingBadge}>
                <Text style={styles.ratingText}>{Number(hotel.rating).toFixed(1)}</Text>
              </View>
              <View>
                <Text style={styles.ratingLabel}>Excellent</Text>
                <Text style={styles.reviewsCount}>{hotel.reviews_count} avis</Text>
              </View>
            </View>
          )}

          {/* Description */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>À propos</Text>
            <Text style={styles.description}>{hotel.description || hotel.short_description || 'Hôtel de qualité avec service premium.'}</Text>
          </View>

          {/* Amenities */}
          {hotel.amenities && hotel.amenities.length > 0 && (
            <View style={styles.section}>
              <Text style={styles.sectionTitle}>Équipements</Text>
              <View style={styles.amenitiesGrid}>
                {hotel.amenities.map((amenity, idx) => {
                  const amenityData = amenityIcons[amenity];
                  if (!amenityData) return null;
                  return <AmenityBadge key={idx} icon={amenityData.icon} label={amenityData.label} />;
                })}
              </View>
            </View>
          )}

          {/* Price */}
          <View style={styles.priceSection}>
            <View>
              <Text style={styles.priceLabel}>À partir de</Text>
              <Text style={styles.price}>{hotel.price_per_night} {hotel.currency}<Text style={styles.priceUnit}>/nuit</Text></Text>
            </View>
          </View>
        </View>
      </ScrollView>

      {/* Bottom Bar */}
      <View style={styles.bottomBar}>
        <View>
          <Text style={styles.bottomPrice}>{hotel.price_per_night} {hotel.currency}</Text>
          <Text style={styles.bottomPriceLabel}>par nuit</Text>
        </View>
        <TouchableOpacity style={styles.bookButton} onPress={() => navigation.navigate('Booking', {type: 'hotel', id: hotel.id})}>
          <LinearGradient colors={gradients.primary} style={styles.bookButtonGradient}>
            <Text style={styles.bookButtonText}>Réserver</Text>
          </LinearGradient>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {flex: 1, backgroundColor: colors.background},
  centerContainer: {flex: 1, justifyContent: 'center', alignItems: 'center'},
  imageContainer: {position: 'relative'},
  mainImage: {width: width, height: 300, justifyContent: 'center', alignItems: 'center'},
  thumbnailScroll: {position: 'absolute', bottom: spacing.md, left: 0, right: 0},
  thumbnail: {width: 60, height: 60, marginLeft: spacing.sm, borderRadius: borderRadius.md, overflow: 'hidden', borderWidth: 2, borderColor: 'transparent'},
  thumbnailActive: {borderColor: colors.white},
  thumbnailImage: {width: '100%', height: '100%'},
  wishlistButton: {position: 'absolute', top: spacing.lg, right: spacing.md, width: 48, height: 48, borderRadius: borderRadius.round, backgroundColor: 'rgba(0,0,0,0.3)', justifyContent: 'center', alignItems: 'center'},
  contentContainer: {padding: spacing.md},
  headerInfo: {flexDirection: 'row', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: spacing.sm},
  titleContainer: {flex: 1},
  hotelName: {fontSize: typography.fontSize.xxl, fontWeight: typography.fontWeight.bold, color: colors.textPrimary, marginBottom: spacing.xs},
  stars: {flexDirection: 'row'},
  featuredBadge: {backgroundColor: colors.accent + '20', paddingHorizontal: spacing.md, paddingVertical: spacing.xs, borderRadius: borderRadius.md},
  featuredText: {fontSize: typography.fontSize.xs, color: colors.accent, fontWeight: typography.fontWeight.bold},
  locationContainer: {flexDirection: 'row', alignItems: 'center', marginBottom: spacing.md},
  locationText: {fontSize: typography.fontSize.md, color: colors.textSecondary, marginLeft: spacing.xs, flex: 1},
  ratingContainer: {flexDirection: 'row', alignItems: 'center', marginBottom: spacing.lg, padding: spacing.md, backgroundColor: colors.white, borderRadius: borderRadius.lg, ...shadows.sm},
  ratingBadge: {backgroundColor: colors.primary, width: 50, height: 50, borderRadius: borderRadius.md, justifyContent: 'center', alignItems: 'center', marginRight: spacing.md},
  ratingText: {fontSize: typography.fontSize.xl, fontWeight: typography.fontWeight.bold, color: colors.white},
  ratingLabel: {fontSize: typography.fontSize.md, fontWeight: typography.fontWeight.bold, color: colors.textPrimary},
  reviewsCount: {fontSize: typography.fontSize.sm, color: colors.textSecondary},
  section: {marginBottom: spacing.lg},
  sectionTitle: {fontSize: typography.fontSize.lg, fontWeight: typography.fontWeight.bold, color: colors.textPrimary, marginBottom: spacing.sm},
  description: {fontSize: typography.fontSize.md, color: colors.textSecondary, lineHeight: typography.fontSize.md * 1.6},
  amenitiesGrid: {flexDirection: 'row', flexWrap: 'wrap'},
  amenityBadge: {width: (width - spacing.md * 3) / 2, flexDirection: 'row', alignItems: 'center', backgroundColor: colors.white, padding: spacing.md, borderRadius: borderRadius.md, marginRight: spacing.sm, marginBottom: spacing.sm, ...shadows.sm},
  amenityText: {fontSize: typography.fontSize.sm, color: colors.textPrimary, marginLeft: spacing.sm},
  priceSection: {backgroundColor: colors.lighter, padding: spacing.md, borderRadius: borderRadius.lg, marginBottom: spacing.xxl},
  priceLabel: {fontSize: typography.fontSize.sm, color: colors.textSecondary, marginBottom: spacing.xs},
  price: {fontSize: typography.fontSize.xxxl, fontWeight: typography.fontWeight.bold, color: colors.primary},
  priceUnit: {fontSize: typography.fontSize.md, color: colors.textSecondary},
  bottomBar: {flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', padding: spacing.md, backgroundColor: colors.white, borderTopWidth: 1, borderTopColor: colors.border, ...shadows.lg},
  bottomPrice: {fontSize: typography.fontSize.xl, fontWeight: typography.fontWeight.bold, color: colors.primary},
  bottomPriceLabel: {fontSize: typography.fontSize.sm, color: colors.textSecondary},
  bookButton: {borderRadius: borderRadius.lg, overflow: 'hidden', ...shadows.md},
  bookButtonGradient: {paddingVertical: spacing.md, paddingHorizontal: spacing.xl},
  bookButtonText: {fontSize: typography.fontSize.lg, fontWeight: typography.fontWeight.bold, color: colors.white},
  errorText: {fontSize: typography.fontSize.lg, color: colors.textSecondary, marginTop: spacing.md},
});

export default HotelDetailsScreen;
