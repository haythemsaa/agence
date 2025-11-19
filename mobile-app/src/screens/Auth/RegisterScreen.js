import React, {useState} from 'react';
import {View, Text, StyleSheet, TouchableOpacity, TextInput, KeyboardAvoidingView, ScrollView, Platform, ActivityIndicator, Alert} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {useAuth} from '../../hooks/useAuth';

const RegisterScreen = ({navigation}) => {
  const {register} = useAuth();
  const [formData, setFormData] = useState({name: '', email: '', password: '', password_confirmation: '', phone: ''});
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});

  const validateForm = () => {
    const newErrors = {};
    if (!formData.name || formData.name.length < 3) newErrors.name = 'Nom complet requis (min 3 caractères)';
    if (!formData.email || !/\S+@\S+\.\S+/.test(formData.email)) newErrors.email = 'Email invalide';
    if (!formData.password || formData.password.length < 8) newErrors.password = 'Mot de passe min 8 caractères';
    if (formData.password !== formData.password_confirmation) newErrors.password_confirmation = 'Les mots de passe ne correspondent pas';
    if (formData.phone && !/^[0-9]{8}$/.test(formData.phone.replace(/\s/g, ''))) newErrors.phone = 'Téléphone invalide (8 chiffres)';
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleRegister = async () => {
    if (!validateForm()) return;
    setLoading(true);
    const result = await register(formData);
    setLoading(false);
    if (!result.success) Alert.alert('Erreur', result.error || 'Erreur lors de l\'inscription');
  };

  const updateField = (field, value) => {
    setFormData(prev => ({...prev, [field]: value}));
    if (errors[field]) setErrors(prev => ({...prev, [field]: null}));
  };

  return (
    <KeyboardAvoidingView style={styles.container} behavior={Platform.OS === 'ios' ? 'padding' : undefined}>
      <ScrollView contentContainerStyle={styles.scrollContent} keyboardShouldPersistTaps="handled">
        <LinearGradient colors={gradients.secondary} style={styles.header}>
          <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
            <Icon name="arrow-back" size={24} color={colors.white} />
          </TouchableOpacity>
          <Icon name="person-add" size={64} color={colors.white} />
          <Text style={styles.headerTitle}>Créer un Compte</Text>
          <Text style={styles.headerSubtitle}>Rejoignez VoyageLuxe</Text>
        </LinearGradient>

        <View style={styles.formContainer}>
          <View style={styles.inputContainer}>
            <Icon name="person-outline" size={20} color={colors.textSecondary} style={styles.inputIcon} />
            <TextInput style={styles.input} placeholder="Nom complet" placeholderTextColor={colors.textSecondary} value={formData.name} onChangeText={(v) => updateField('name', v)} autoCapitalize="words" />
          </View>
          {errors.name && <Text style={styles.errorText}>{errors.name}</Text>}

          <View style={styles.inputContainer}>
            <Icon name="mail-outline" size={20} color={colors.textSecondary} style={styles.inputIcon} />
            <TextInput style={styles.input} placeholder="Adresse email" placeholderTextColor={colors.textSecondary} value={formData.email} onChangeText={(v) => updateField('email', v)} keyboardType="email-address" autoCapitalize="none" />
          </View>
          {errors.email && <Text style={styles.errorText}>{errors.email}</Text>}

          <View style={styles.inputContainer}>
            <Icon name="call-outline" size={20} color={colors.textSecondary} style={styles.inputIcon} />
            <TextInput style={styles.input} placeholder="Téléphone (optionnel)" placeholderTextColor={colors.textSecondary} value={formData.phone} onChangeText={(v) => updateField('phone', v)} keyboardType="phone-pad" />
          </View>
          {errors.phone && <Text style={styles.errorText}>{errors.phone}</Text>}

          <View style={styles.inputContainer}>
            <Icon name="lock-closed-outline" size={20} color={colors.textSecondary} style={styles.inputIcon} />
            <TextInput style={styles.input} placeholder="Mot de passe" placeholderTextColor={colors.textSecondary} value={formData.password} onChangeText={(v) => updateField('password', v)} secureTextEntry={!showPassword} autoCapitalize="none" />
            <TouchableOpacity onPress={() => setShowPassword(!showPassword)} style={styles.eyeIcon}>
              <Icon name={showPassword ? 'eye-outline' : 'eye-off-outline'} size={20} color={colors.textSecondary} />
            </TouchableOpacity>
          </View>
          {errors.password && <Text style={styles.errorText}>{errors.password}</Text>}

          <View style={styles.inputContainer}>
            <Icon name="lock-closed-outline" size={20} color={colors.textSecondary} style={styles.inputIcon} />
            <TextInput style={styles.input} placeholder="Confirmer mot de passe" placeholderTextColor={colors.textSecondary} value={formData.password_confirmation} onChangeText={(v) => updateField('password_confirmation', v)} secureTextEntry={!showConfirmPassword} autoCapitalize="none" />
            <TouchableOpacity onPress={() => setShowConfirmPassword(!showConfirmPassword)} style={styles.eyeIcon}>
              <Icon name={showConfirmPassword ? 'eye-outline' : 'eye-off-outline'} size={20} color={colors.textSecondary} />
            </TouchableOpacity>
          </View>
          {errors.password_confirmation && <Text style={styles.errorText}>{errors.password_confirmation}</Text>}

          <TouchableOpacity style={[styles.registerButton, loading && styles.registerButtonDisabled]} onPress={handleRegister} disabled={loading}>
            <LinearGradient colors={gradients.secondary} style={styles.registerButtonGradient}>
              {loading ? <ActivityIndicator color={colors.white} /> : <Text style={styles.registerButtonText}>S'inscrire</Text>}
            </LinearGradient>
          </TouchableOpacity>

          <View style={styles.termsContainer}>
            <Text style={styles.termsText}>En vous inscrivant, vous acceptez nos </Text>
            <TouchableOpacity><Text style={styles.termsLink}>Conditions d'utilisation</Text></TouchableOpacity>
          </View>

          <View style={styles.loginContainer}>
            <Text style={styles.loginText}>Vous avez déjà un compte ? </Text>
            <TouchableOpacity onPress={() => navigation.navigate('Login')}>
              <Text style={styles.loginLink}>Se connecter</Text>
            </TouchableOpacity>
          </View>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: {flex: 1, backgroundColor: colors.background},
  scrollContent: {flexGrow: 1},
  header: {paddingTop: spacing.xxl, paddingBottom: spacing.xl, paddingHorizontal: spacing.lg, borderBottomLeftRadius: borderRadius.xxl, borderBottomRightRadius: borderRadius.xxl, alignItems: 'center', position: 'relative'},
  backButton: {position: 'absolute', top: spacing.lg, left: spacing.lg, width: 40, height: 40, borderRadius: borderRadius.round, backgroundColor: 'rgba(255, 255, 255, 0.2)', justifyContent: 'center', alignItems: 'center'},
  headerTitle: {fontSize: typography.fontSize.xxxl, fontWeight: typography.fontWeight.bold, color: colors.white, marginTop: spacing.md},
  headerSubtitle: {fontSize: typography.fontSize.md, color: colors.white, opacity: 0.9, marginTop: spacing.sm},
  formContainer: {flex: 1, padding: spacing.lg},
  inputContainer: {flexDirection: 'row', alignItems: 'center', backgroundColor: colors.white, borderRadius: borderRadius.lg, marginBottom: spacing.sm, paddingHorizontal: spacing.md, ...shadows.sm},
  inputIcon: {marginRight: spacing.sm},
  input: {flex: 1, paddingVertical: spacing.md, fontSize: typography.fontSize.md, color: colors.textPrimary},
  eyeIcon: {padding: spacing.sm},
  errorText: {fontSize: typography.fontSize.sm, color: colors.error, marginBottom: spacing.sm, marginLeft: spacing.sm},
  registerButton: {borderRadius: borderRadius.lg, overflow: 'hidden', marginTop: spacing.md, marginBottom: spacing.lg, ...shadows.md},
  registerButtonDisabled: {opacity: 0.6},
  registerButtonGradient: {paddingVertical: spacing.md, alignItems: 'center'},
  registerButtonText: {fontSize: typography.fontSize.lg, fontWeight: typography.fontWeight.bold, color: colors.white},
  termsContainer: {flexDirection: 'row', flexWrap: 'wrap', justifyContent: 'center', marginBottom: spacing.md},
  termsText: {fontSize: typography.fontSize.sm, color: colors.textSecondary},
  termsLink: {fontSize: typography.fontSize.sm, color: colors.secondary, fontWeight: typography.fontWeight.bold},
  loginContainer: {flexDirection: 'row', justifyContent: 'center'},
  loginText: {fontSize: typography.fontSize.md, color: colors.textSecondary},
  loginLink: {fontSize: typography.fontSize.md, color: colors.secondary, fontWeight: typography.fontWeight.bold},
});

export default RegisterScreen;
