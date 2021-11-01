import React from 'react';
import styled from "styled-components";
import SkillTags from '../Molecules/SkillTags';
import DetailInfo from '../Atoms/DetailInfo';
import Grid from '@mui/material/Grid';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: auto;
  margin-bottom: 2rem;
  border: 1px solid #e2e2e2;
`;

const ProjectName = styled(Grid)`
  margin-left: 2rem;
  font-weight: bold;
  font-size: 1.6rem;
  margin-bottom: 1rem;
`;

const DetailHeader = ({ data }) => {
  return (
    <ContainerGrid>
      <img src="/images/share/no_image.jpeg" alt="noimage" height="350" width="100%" />
      <SkillTags skills={[data.language, data.sub_language]} detail />
      <ProjectName>{data.project_name}</ProjectName>
      <Grid container justify="flex-start">
        <DetailInfo item title="稼働時間" value={data.work_frequency} />
        <DetailInfo item title="募集人数" value={`${data.number_of_application}人`} />
        <DetailInfo item title="エンジニア歴" value={`${data.minimum_experience}年以上`} />
        <DetailInfo item title="エリア" value="全国/フルリモート(在宅)" />
      </Grid>
    </ContainerGrid>
  );
}

export default DetailHeader;
