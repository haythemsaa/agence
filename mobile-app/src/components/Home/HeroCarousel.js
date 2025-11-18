import React from 'react';
import {View, Text, StyleSheet} from 'react-native';
const HeroCarousel = () => (<View style={styles.container}><Text style={styles.text}>Hero Carousel</Text></View>);
const styles = StyleSheet.create({container:{height:200,backgroundColor:'#667eea',justifyContent:'center',alignItems:'center',margin:16,borderRadius:12},text:{color:'#fff',fontSize:20,fontWeight:'bold'}});
export default HeroCarousel;
