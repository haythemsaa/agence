import React from 'react';
import {View, Text, StyleSheet} from 'react-native';
import {colors} from '../../theme/colors';

const HotelsScreen = () => (
  <View style={styles.container}>
    <Text style={styles.text}>Hotels Screen - À développer</Text>
  </View>
);

const styles = StyleSheet.create({
  container: {flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: colors.background},
  text: {fontSize: 18, color: colors.textPrimary},
});

export default HotelsScreen;
