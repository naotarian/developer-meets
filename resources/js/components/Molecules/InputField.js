import React from 'react';
import InputLabel from '@mui/material/InputLabel';
import OutlinedInput from '@mui/material/OutlinedInput';
import FormHelperText from '@mui/material/FormHelperText';
import FormControl from '@mui/material/FormControl';

const InputField = ({ label, type, fullWidth, multiline, value, onChange, required, submit }) => {
  const MAX_LENGTH = multiline ? 1000 : 50;

  const handleChange = (e) => {
    onChange(e.target.value);
  };

  return (
    <FormControl
      variant='outlined'
      fullWidth={fullWidth}
      sx={{
        m: '1rem',
        width: fullWidth ? null : { xs: 'calc(100% - 2rem)', md: 'calc(50% - 2rem)' }
      }}
    >
      <InputLabel htmlFor={`input-${label}`}>{label}</InputLabel>
      <OutlinedInput
        id={`input-${label}`}
        label={label}
        type={type}
        error={
          (type === 'number' && value && value < 0) ||
          (type === 'text' && submit && !value) ||
          (type === 'text' && value.length > MAX_LENGTH) ||
          false
        }
        multiline={multiline}
        rows={multiline ? 5 : null}
        value={value || ''}
        onChange={handleChange}
      />
      <FormHelperText id={`input-${label}`}>
        {required ? '*必須項目です' : ' '}
        {(type === 'text' && value.length > MAX_LENGTH) ? ` *${MAX_LENGTH}文字以下で設定してください` : ' '}
      </FormHelperText>
    </FormControl>
  );
};

export default InputField;
