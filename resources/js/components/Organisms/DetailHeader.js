import React from 'react';
import styled from "styled-components";
import SkillTags from '../Molecules/SkillTags';
import DetailInfo from '../Atoms/DetailInfo';
import Grid from '@mui/material/Grid';
import Card from '@mui/material/Card';

const ContainerGrid = styled(Card)`
  width: 100%;
  height: auto;
  border: 1px solid #e2e2e2;
  padding-bottom: 20px;
`;

const ProjectName = styled(Grid)`
  margin-left: 2rem;
  font-weight: bold;
  font-size: 1.6rem;
  margin-bottom: 1rem;
`;

const DetailHeader = ({ data }) => {
  let urlCode = data.user_url_code;
  let project_url_code = data.url_code;
  let img = data.project_image_sp;
  return (
    <ContainerGrid>
      {urlCode && img ? (
        <img src={`/get_request_image?id=${urlCode}&name=${img}&dir=project&url_code=${project_url_code}`} width="100%" />
        ) : (
        <img src="/images/share/no_image.jpeg" width="100%" height="300px" />
      )}
      <SkillTags skills={[data.language, data.sub_language]} detail />
      <ProjectName>{data.project_name}</ProjectName>
      <Grid container justify="flex-start">
        <DetailInfo item title="稼働時間" value={data.work_frequency} />
        <DetailInfo item title="募集人数" value={`${data.number_of_application}人`} />
        <DetailInfo item title="エンジニア歴" value={`${data.minimum_experience}年以上`} />
        <DetailInfo item title="エリア" />
      </Grid>
    </ContainerGrid>
  );
}

export default DetailHeader;
