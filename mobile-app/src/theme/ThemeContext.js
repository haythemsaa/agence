import React, {createContext, useContext, useState} from 'react';
import {colors, gradients} from './colors';
import {spacing, typography, borderRadius, shadows} from './styles';

const ThemeContext = createContext();

export const ThemeProvider = ({children}) => {
  const [isDarkMode, setIsDarkMode] = useState(false);

  const theme = {
    colors: isDarkMode ? getDarkColors() : colors,
    gradients,
    spacing,
    typography,
    borderRadius,
    shadows,
    isDarkMode,
    toggleTheme: () => setIsDarkMode(!isDarkMode),
  };

  return (
    <ThemeContext.Provider value={theme}>{children}</ThemeContext.Provider>
  );
};

export const useTheme = () => {
  const context = useContext(ThemeContext);
  if (!context) {
    throw new Error('useTheme must be used within ThemeProvider');
  }
  return context;
};

// Dark mode color adjustments
const getDarkColors = () => ({
  ...colors,
  background: '#1a1a1a',
  cardBackground: '#2d2d2d',
  textPrimary: '#ffffff',
  textSecondary: '#b0b0b0',
  border: '#404040',
});

export default ThemeContext;
