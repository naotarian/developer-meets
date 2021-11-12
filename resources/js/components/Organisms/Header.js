import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import UserIcon from '../Atoms/UserIcon';
import AppBar from '@mui/material/AppBar';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Link from '@mui/material/Link';
import IconButton from '@mui/material/IconButton';
import MenuItem from '@mui/material/MenuItem';
import Menu from '@mui/material/Menu';
import Drawer from '@mui/material/Drawer';
import MenuIcon from '@mui/icons-material/Menu';
import Divider from '@mui/material/Divider';
import { grey } from '@mui/material/colors';

const StyledAppBar = styled(AppBar)`
  background: deepskyblue;
`;

const StyledLink = styled(Link)`
  color: #ffffff;
  margin-left: 0.5rem;
  margin-right: 0.5rem;
  &:hover {
    color: #ffffff;
  }
`;

const MyPageLink = styled(Link)`
  color: #000000;
  &:hover {
    color: #000000;
  }
`;

const StyledIconButton = styled(IconButton)`
  outline: none !important;
`;

const DrawerMenuContainer = styled(Grid)`
  width: 200px;
  padding-top: 2rem;
  padding-bottom: 2rem;
  // background: red;
`;

const StyledIconGrid = styled(Grid)`
  border: 3px solid deepskyblue;
  border-radius: 50px;
`;

const DrawerMenuLink = styled(Link)`
  color: #000000;
  &:hover {
    color: #000000;
  }
`;

const Header = () => {
  const [host, setHost] = useState('');
  const [loginUser, setLoginUser] = useState(null);
  const [userIconPath, setUserIconPath] = useState(null);
  const [menuAnchorEl, setMenuAnchorEl] = useState(false);
  const [openDrawer, setOpenDrawer] = useState(false);
  const [adminFlag, setAdminFlag] = useState(null);
  
  useEffect(() => {
    setHost(location.host);
  }, []);

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let url = `${protocol}://${host}/api/get_user`;
      axios.get(url).then(res => {
        setLoginUser(res.data.user ? res.data.user : 'NoUser');
        setUserIconPath(`${protocol}://${host}/api/get_user_icon`);
        setAdminFlag(res.data.user.id);
      });
    }
  }, [host]);

  const logout = () => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/logout`;
    axios.post(url).then(() => {
      window.location.reload();
    });
  };

  return (
    <React.Fragment>
      <Box sx={{ flexGrow: 1 }}>
        <StyledAppBar position="fixed" elevation={1}>
          <Toolbar sx={{ height: 60 }}>
            <Typography variant="h6" noWrap component="div">
              <StyledLink underline="none" href='/'>Developer-Meets</StyledLink>
            </Typography>
            <Box sx={{ flexGrow: 1 }} />
            {/* PCサイズ */}
            <Box sx={{ display: { xs: 'none', md: 'flex' } }} >
              <StyledLink underline="none" href='/seek'>プロジェクトを探す</StyledLink>
              <StyledLink underline="none" href='/make'>プロジェクトを作る</StyledLink>
              {adminFlag == 1 ? (<StyledLink underline="none" href='/admin'>管理者ページ</StyledLink>) : ('')}
            </Box>
            <Box sx={{ display: { xs: 'none', md: 'block' }, marginLeft: 2 }} >
              {loginUser &&
                loginUser === 'NoUser' ? (
                  <StyledLink underline="none" href='/login'>ログイン</StyledLink>
                ) : (
                  <div onClick={(e) => setMenuAnchorEl(e.currentTarget)}>
                    <UserIcon size={36} imgPath={userIconPath} />
                  </div>
                )
              }
            </Box>
            <Menu
              open={Boolean(menuAnchorEl)}
              anchorEl={menuAnchorEl}
              keepMounted
              disableAutoFocusItem
              anchorOrigin={{ vertical: 'bottom',horizontal: 'center' }}
              transformOrigin={{ vertical: 'top', horizontal: 'center' }}
              onClose={() => setMenuAnchorEl(false)}
            >
              <MenuItem><MyPageLink underline="none" href='/my_page'>マイページ</MyPageLink></MenuItem>
              <MenuItem><Grid onClick={() => logout()}>ログアウト</Grid></MenuItem>
            </Menu>
            {/* SPサイズ */}
            <Box sx={{ display: { xs: 'flex', md: 'none' } }}>
              <StyledIconButton
                size="large"
                aria-haspopup="true"
                onClick={() => setOpenDrawer(true)}
              >
                <MenuIcon />
              </StyledIconButton>
              <Drawer
                open={openDrawer}
                anchor='right'
                onClose={() => setOpenDrawer(false)}
              >
                <DrawerMenuContainer container flexDirection='column' alignItems='center'>
                  <MenuItem><StyledIconGrid><UserIcon size={80} imgPath={userIconPath} /></StyledIconGrid></MenuItem>
                  {loginUser && <MenuItem><DrawerMenuLink underline="none" href='/my_page'>マイページ</DrawerMenuLink></MenuItem> }
                  <Divider color={grey[300]} width='80%' />
                  <MenuItem><DrawerMenuLink underline="none" href='/seek'>プロジェクトを探す</DrawerMenuLink></MenuItem>
                  <MenuItem><DrawerMenuLink underline="none" href='/make'>プロジェクトを作る</DrawerMenuLink></MenuItem>
                  {adminFlag == 1 ? (<MenuItem><DrawerMenuLink underline="none" href='/admin'>管理者ページ</DrawerMenuLink></MenuItem>) : ('')}
                  <MenuItem>
                    {loginUser ? (<Grid onClick={() => logout()}>ログアウト</Grid>) : (<DrawerMenuLink underline="none" href='/login'>ログイン</DrawerMenuLink>)}
                  </MenuItem>
                </DrawerMenuContainer>
              </Drawer>
            </Box>
          </Toolbar>
        </StyledAppBar>
      </Box>
      <Box sx={{ height: 60 }} />
    </React.Fragment>
  );
};

export default Header;

ReactDOM.render(<Header />, document.getElementById('master_header'));
