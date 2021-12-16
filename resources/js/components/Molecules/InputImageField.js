import React from 'react';
import styled from 'styled-components';

import InputLabel from '@mui/material/InputLabel';
import OutlinedInput from '@mui/material/OutlinedInput';
import FormControl from '@mui/material/FormControl';
import IconButton from '@mui/material/IconButton';
import PhotoCamera from '@mui/icons-material/PhotoCamera';

const HiddenInput = styled.input`
  display: none;
`;

const InputImageField = ({ label, openDialog, setSrcImg, fileName, setFileName, deleteProjectImg }) => {

  const selectImageFile = (e) => {
    if (e.target.files && e.target.files.length > 0) {
      const reader = new FileReader();
      reader.addEventListener('load', () => setSrcImg(reader.result));
      reader.readAsDataURL(e.target.files[0]);
      openDialog();
      setFileName(e.target.files[0].name);
    }
  };

  const deleteFile = () => {
    deleteProjectImg();
    setFileName('');
  };

  return (
    <React.Fragment>
      <FormControl
        variant='outlined'
        sx={{
          m: '1rem',
          width: { xs: 'calc(85% - 2rem)', md: 'calc(45% - 2rem)' }
        }}
        disabled={!fileName}
      >
        <InputLabel htmlFor={`input-${label}`}>{label}</InputLabel>
        <OutlinedInput id={`input-${label}`} label={label} value={fileName || ''} onChange={deleteFile} />
      </FormControl>
      <label htmlFor='icon-button-file' style={{ margin:'auto', paddingBottom: '1rem' }}>
        <HiddenInput accept='image/*' id='icon-button-file' type='file' onChange={selectImageFile} />
        <IconButton aria-label='upload picture' component='span' style={{outline: 'none'}}><PhotoCamera /></IconButton>
      </label>
    </React.Fragment>
  );
};

export default InputImageField;
