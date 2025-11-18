import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  Dimensions,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';

const {width} = Dimensions.get('window');
const CARD_WIDTH = width * 0.75;

const PackageCard = ({package: pkg, style, onPress}) => {
  const getGradient = (type) => {
    switch (type) {
      case 'omra':
        return gradients.omra;
      case 'circuit':
        return gradients.sunset;
      case 'sejour':
        return gradients.primary;
      default:
        return gradients.secondary;
    }
  };

  return (
    <TouchableOpacity
      style={[styles.container, style]}
      onPress={onPress}
      activeOpacity={0.8}>
      <LinearGradient
        colors={getGradient(pkg.type)}
        style={styles.imageGradient}>
        <Icon name="map-outline" size={64} color={colors.white} style={styles.icon} />

        {/* Type Badge */}
        <View style={styles.typeBadge}>
          <Text style={styles.typeText}>{pkg.type?.toUpperCase()}</Text>
        </View>

        {/* TRE Badge */}
        {pkg.is_tre_package && (
          <View style={styles.treBadge}>
            <Icon name="globe-outline" size={12} color={colors.white} />
            <Text style={styles.treText}>TRE</Text>
          </View>
        )}
      </LinearGradient>

      <View style={styles.content}>
        <Text style={styles.title} numberOfLines={2}>
          {pkg.title}
        </Text>

        {pkg.short_description && (
          <Text style={styles.description} numberOfLines={2}>
            {pkg.short_description}
          </Text>
        )}

        <View style={styles.details}>
          <View style={styles.detailRow}>
            <Icon name="calendar-outline" size={14} color={colors.primary} />
            <Text style={styles.detailText}>
              {pkg.duration_days}J / {pkg.duration_nights}N
            </Text>
          </View>

          {pkg.destinations && pkg.destinations.length > 0 && (
            <View style={styles.detailRow}>
              <Icon name="location-outline" size={14} color={colors.primary} />
              <Text style={styles.detailText} numberOfLines={1}>
                {pkg.destinations.slice(0, 2).join(', ')}
                {pkg.destinations.length > 2 && ` +${pkg.destinations.length - 2}`}
              </Text>
            </View>
          )}
        </View>

        <View style={styles.footer}>
          <View>
            <Text style={styles.priceLabel}>À partir de</Text>
            <Text style={styles.price}>
              {Number(pkg.price_adult).toLocaleString()}{' '}
              <Text style={styles.currency}>{pkg.currency || 'TND'}</Text>
            </Text>
          </View>
          <View style={styles.button}>
            <Icon name="arrow-forward" size={20} color={colors.primary} />
          </View>
        </View>
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  container: {
    width: CARD_WIDTH,
    backgroundColor: colors.white,
    borderRadius: borderRadius.xl,
    overflow: 'hidden',
    ...shadows.md,
  },
  imageGradient: {
    height: 160,
    justifyContent: 'center',
    alignItems: 'center',
    position: 'relative',
  },
  icon: {
    opacity: 0.3,
  },
  typeBadge: {
    position: 'absolute',
    top: spacing.sm,
    left: spacing.sm,
    backgroundColor: colors.white,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
  },
  typeText: {
    color: colors.dark,
    fontSize: typography.fontSize.xs,
    fontWeight: typography.fontWeight.bold,
  },
  treBadge: {
    position: 'absolute',
    top: spacing.sm,
    right: spacing.sm,
    backgroundColor: colors.success,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
    flexDirection: 'row',
    alignItems: 'center',
  },
  treText: {
    color: colors.white,
    fontSize: typography.fontSize.xs,
    fontWeight: typography.fontWeight.bold,
    marginLeft: spacing.xs,
  },
  content: {
    padding: spacing.md,
  },
  title: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.sm,
  },
  description: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
    marginBottom: spacing.md,
    lineHeight: typography.fontSize.sm * 1.4,
  },
  details: {
    marginBottom: spacing.md,
  },
  detailRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.xs,
  },
  detailText: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
    marginLeft: spacing.sm,
    flex: 1,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    borderTopWidth: 1,
    borderTopColor: colors.border,
    paddingTop: spacing.md,
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
  currency: {
    fontSize: typography.fontSize.sm,
    fontWeight: typography.fontWeight.normal,
  },
  button: {
    width: 40,
    height: 40,
    borderRadius: borderRadius.round,
    backgroundColor: colors.lighter,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default PackageCard;
