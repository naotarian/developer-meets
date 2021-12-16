import React, { useState, useEffect, useRef, useCallback } from 'react';
import ReactCrop from 'react-image-crop';
import 'react-image-crop/dist/ReactCrop.css';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';

const PreviewDialog = ({ open, srcImage, closeDialog, setProjectImage }) => {
  const imgRef = useRef(null);
  const initialCrop = { unit: '%', width: 100, aspect: 2.5 / 1 };
  const [crop, setCrop] = useState(initialCrop);
  const [finalCrop, setFinalCrop] = useState(null);

  const onLoad = useCallback((img) => {
    imgRef.current = img;
  }, []);

  useEffect(() => {
    if (imgRef && finalCrop && finalCrop.width && finalCrop.height) {
      const canvas = document.createElement('canvas');
      const scaleX = imgRef.current.naturalWidth / imgRef.current.width;
      const scaleY = imgRef.current.naturalHeight / imgRef.current.height;
      const ctx = canvas.getContext('2d');
      canvas.width = finalCrop.width;
      canvas.height = finalCrop.height;
      ctx.drawImage(
        imgRef.current,
        finalCrop.x * scaleX,
        finalCrop.y * scaleY,
        finalCrop.width * scaleX,
        finalCrop.height * scaleY,
        0,
        0,
        finalCrop.width,
        finalCrop.height
      );
      const base64Image = canvas.toDataURL('image/jpg');
      setProjectImage(base64Image);
    }
  }, [finalCrop]);

  const onClose = () => {
    setFinalCrop(null);
    closeDialog();
  };

  return (
    <Dialog open={open}>
      <DialogTitle>
        範囲を指定してください
      </DialogTitle>
      <DialogContent>
        {srcImage &&
        <ReactCrop
          src={srcImage}
          crop={crop}
          onImageLoaded={onLoad}
          minWidth={200}
          minHeight={200}
          onChange={setCrop}
          onComplete={(c) => setFinalCrop(c)}
          imageStyle={{
            width: '100%'
          }}
        />
        }
      </DialogContent>
      <DialogActions>
        <Button variant='outlined' onClick={onClose}>
          決定
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default PreviewDialog;
