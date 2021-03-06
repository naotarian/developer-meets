import React from 'react';
import styled from 'styled-components';
import OutlinedInput from '@mui/material/OutlinedInput';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import ListItemText from '@mui/material/ListItemText';
import Select from '@mui/material/Select';
import Checkbox from '@mui/material/Checkbox';

const StyledInputLabel = styled(InputLabel)`
  font-size: 0.9rem !important;
`;

const StyledSelect = styled(Select)`
  font-size: 0.9rem !important;
  height: 45px;
`;

const StyledText = styled(ListItemText)`
  font-size: 0.7rem !important;
`;

const languages = [
  'C',
  'C#',
  'Dart',
  'C++',
  'Cantana',
  'COBOL',
  'CoffeeScript',
  'Go',
  'GAS',
  'JavaScript',
  'Kotlin',
  'MQL',
  'Objective-C',
  'Perl',
  'PHP',
  'PowerShell',
  'Python',
  'Ruby',
  'Rust',
  'Scala',
  'sh',
  'Swift',
  'TypeScript',
  'VBScript',
  'VisualBasic',
  '.NET',
];

const LanguageSelectBox = ({ searchLanguage, setSearchLanguage }) => {
  const handleChange = (event) => {
    const {target: { value }} = event;
    setSearchLanguage(typeof value === 'string' ? value.split(',') : value);
  };

  return (
    <FormControl sx={{ m: 1, minWidth: 180 }}>
      <StyledInputLabel id="言語-label">言語</StyledInputLabel>
      <StyledSelect
        labelId="言語-label"
        id="言語-checkbox"
        multiple
        value={searchLanguage}
        onChange={handleChange}
        input={<OutlinedInput label="言語" />}
        renderValue={(selected) => selected.join(', ')}
        MenuProps={{
          PaperProps: {
            style: {
              maxHeight: 250,
              width: 250,
            },
          }
        }}
      >
        {languages.map((lan) => (
          <MenuItem key={lan} value={lan}>
            <Checkbox checked={searchLanguage.indexOf(lan) > -1} />
            <StyledText primary={lan} disableTypography />
          </MenuItem>
        ))}
      </StyledSelect>
    </FormControl>
  );
};

export default LanguageSelectBox;
