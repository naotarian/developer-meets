import React from 'react';
import styled from 'styled-components';
import SkillTags from '../Molecules/SkillTags';
import DetailInfo from '../Atoms/DetailInfo';
import Grid from '@mui/material/Grid';
import UserInfo from '../Molecules/UserInfo';

const ProjectImg = styled.img`
  width: 100%;
  max-height: 300px;
`;

const Contents = styled(Grid)`
  padding-left: 1rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
`;

const ProjectName = styled(Grid)`
  font-weight: bold;
  font-size: 1.6rem;
  margin-bottom: 1rem;
`;

const UserInfoGrid = styled.a`
  display: inline-block;
  margin-top: 1rem;
  text-decoration: none;
  color: #000000;
  &:hover {
    color: #000000;
  }
`;

const DetailHeader = ({ data, userImgPath, projectImgPath }) => {
  return (
    <React.Fragment>
      <ProjectImg src={projectImgPath} />
      <Contents>
        <SkillTags skills={[data.language, data.sub_language]} detail />
        <ProjectName>{data.project_name}</ProjectName>
        <Grid container justify='flex-start'>
          <DetailInfo item title='稼働時間' value={data.work_frequency} />
          <DetailInfo item title='募集人数' value={`${data.number_of_application}人`} />
          <DetailInfo item title='エンジニア歴' value={`${data.minimum_experience}年以上`} />
          <DetailInfo item title='エリア' />
        </Grid>
        <UserInfoGrid href={`/user_info/${data.created_by.user_name}`}>
          <UserInfo username={data.created_by.user_name} imgPath={userImgPath ? userImgPath : null} />
        </UserInfoGrid>
      </Contents>
    </React.Fragment>
  );
};

export default DetailHeader;
