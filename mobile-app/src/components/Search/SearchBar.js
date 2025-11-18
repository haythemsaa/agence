import React from 'react';
import {TouchableOpacity, Text, StyleSheet} from 'react-native';
const SearchBar = ({onPress, placeholder}) => (<TouchableOpacity style={styles.container} onPress={onPress}><Text style={styles.text}>{placeholder}</Text></TouchableOpacity>);
const styles = StyleSheet.create({container:{backgroundColor:'#fff',padding:16,margin:16,borderRadius:12,elevation:2},text:{color:'#7f8c8d'}});
export default SearchBar;
