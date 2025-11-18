import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  Image,
  Dimensions,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';

const {width} = Dimensions.get('window');
const CARD_WIDTH = width * 0.7;

const HotelCard = ({hotel, style, onPress}) => {
  const renderStars = (count) => {
    return Array(count)
      .fill(0)
      .map((_, i) => (
        <Icon key={i} name="star" size={14} color={colors.star} />
      ));
  };

  return (
    <TouchableOpacity
      style={[styles.container, style]}
      onPress={onPress}
      activeOpacity={0.8}>
      <View style={styles.imageContainer}>
        {hotel.images && hotel.images.length > 0 ? (
          <Image
            source={{uri: hotel.images[0]}}
            style={styles.image}
            resizeMode="cover"
          />
        ) : (
          <LinearGradient
            colors={['#667eea', '#764ba2']}
            style={styles.imagePlaceholder}>
            <Icon name="business-outline" size={48} color={colors.white} />
          </LinearGradient>
        )}

        {/* Featured Badge */}
        {hotel.is_featured && (
          <View style={styles.featuredBadge}>
            <Icon name="star" size={12} color={colors.white} />
            <Text style={styles.featuredText}>Vedette</Text>
          </View>
        )}

        {/* Flash Sale Badge */}
        {hotel.is_flash_sale && (
          <View style={styles.flashBadge}>
            <Icon name="flash" size={12} color={colors.white} />
            <Text style={styles.flashText}>Promo</Text>
          </View>
        )}
      </View>

      <View style={styles.content}>
        <View style={styles.header}>
          <Text style={styles.name} numberOfLines={1}>
            {hotel.name}
          </Text>
          <View style={styles.stars}>{renderStars(hotel.stars || 0)}</View>
        </View>

        <View style={styles.location}>
          <Icon name="location-outline" size={14} color={colors.textSecondary} />
          <Text style={styles.locationText} numberOfLines={1}>
            {hotel.city}, {hotel.country}
          </Text>
        </View>

        {hotel.rating > 0 && (
          <View style={styles.rating}>
            <View style={styles.ratingBadge}>
              <Text style={styles.ratingText}>
                {Number(hotel.rating).toFixed(1)}
              </Text>
            </View>
            <Text style={styles.reviewsText}>
              ({hotel.reviews_count || 0} avis)
            </Text>
          </View>
        )}

        {hotel.price_per_night && (
          <View style={styles.priceContainer}>
            <Text style={styles.priceLabel}>À partir de</Text>
            <Text style={styles.price}>
              {hotel.price_per_night} {hotel.currency || 'TND'}
              <Text style={styles.priceUnit}>/nuit</Text>
            </Text>
          </View>
        )}
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  container: {
    width: CARD_WIDTH,
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    overflow: 'hidden',
    ...shadows.md,
  },
  imageContainer: {
    height: 180,
    position: 'relative',
  },
  image: {
    width: '100%',
    height: '100%',
  },
  imagePlaceholder: {
    width: '100%',
    height: '100%',
    justifyContent: 'center',
    alignItems: 'center',
  },
  featuredBadge: {
    position: 'absolute',
    top: spacing.sm,
    right: spacing.sm,
    backgroundColor: colors.accent,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
    flexDirection: 'row',
    alignItems: 'center',
  },
  featuredText: {
    color: colors.white,
    fontSize: typography.fontSize.xs,
    fontWeight: typography.fontWeight.bold,
    marginLeft: spacing.xs,
  },
  flashBadge: {
    position: 'absolute',
    top: spacing.sm,
    left: spacing.sm,
    backgroundColor: colors.error,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
    flexDirection: 'row',
    alignItems: 'center',
  },
  flashText: {
    color: colors.white,
    fontSize: typography.fontSize.xs,
    fontWeight: typography.fontWeight.bold,
    marginLeft: spacing.xs,
  },
  content: {
    padding: spacing.md,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: spacing.xs,
  },
  name: {
    flex: 1,
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginRight: spacing.sm,
  },
  stars: {
    flexDirection: 'row',
  },
  location: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  locationText: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
    marginLeft: spacing.xs,
    flex: 1,
  },
  rating: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  ratingBadge: {
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.sm,
    paddingVertical: 2,
    borderRadius: borderRadius.sm,
    marginRight: spacing.sm,
  },
  ratingText: {
    color: colors.white,
    fontSize: typography.fontSize.sm,
    fontWeight: typography.fontWeight.bold,
  },
  reviewsText: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
  },
  priceContainer: {
    borderTopWidth: 1,
    borderTopColor: colors.border,
    paddingTop: spacing.sm,
    marginTop: spacing.sm,
  },
  priceLabel: {
    fontSize: typography.fontSize.xs,
    color: colors.textSecondary,
    marginBottom: 2,
  },
  price: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.primary,
  },
  priceUnit: {
    fontSize: typography.fontSize.sm,
    fontWeight: typography.fontWeight.normal,
    color: colors.textSecondary,
  },
});

export default HotelCard;
